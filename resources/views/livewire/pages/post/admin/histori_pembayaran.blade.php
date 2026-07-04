<?php

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Penghuni;
use App\Models\Pengajuan;

new #[Layout('layouts.admin')] class extends Component
{
    public $search = '';

    public function mount()
    {
        $this->search = request()->query('search', '');
    }

    public function render()
    {
        return view(
            'livewire.pages.post.admin.histori_pembayaran',
            [
                'pembayarans' => \App\Models\Pembayaran::with([
                    'pengajuan.kamar'
                ])
                ->when($this->search, function ($query) {
                    $query->whereHas('pengajuan', function ($q) {
                        $q->where('nama', 'like', '%' . $this->search . '%');
                    });
                })
                ->latest()
                ->get()
            ]
        );
    }
};

?>

<div class="p-6">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <div>
            <h1 class="text-2xl font-bold text-slate-800">Histori Pembayaran</h1>
            <p class="text-slate-500 mt-1">{{ $search ?: 'Semua Penghuni' }}</p>
        </div>

        <!-- SEARCH -->
        <div class="w-full md:w-[350px]">
            <input
                type="text"
                wire:model.live="search"
                placeholder="Cari nama penghuni..."
                class="w-full rounded-2xl px-5 py-3 shadow
                bg-white/60 focus:bg-[#7FD6DA]/10
                outline-none transition"
        />
        </div>

    </div>

    <!-- TABLE -->
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">

        <table class="w-full text-sm">

            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-slate-500 text-xs font-semibold uppercase tracking-wide">
                    <th class="text-left px-6 py-4">Nama Penghuni</th>
                    <th class="text-left px-6 py-4">Kamar</th>
                    <th class="text-left px-6 py-4">Periode</th>
                    <th class="text-left px-6 py-4">Nominal</th>
                    <th class="text-left px-6 py-4">Tanggal Bayar</th>
                    <th class="text-left px-6 py-4">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">

                @forelse ($pembayarans as $item)

                    <tr class="hover:bg-slate-50 transition-colors">

                        <td class="px-6 py-4 font-semibold text-slate-800">
                            {{ $item->pengajuan->nama }}
                        </td>

                        <td class="px-6 py-4 text-slate-500">
                            {{ $item->pengajuan?->kamar?->nomor_kamar ?? '-' }}
                        </td>

                        <td class="px-6 py-4 text-slate-500">
                            {{ $item->bulan }} {{ $item->tahun }}
                        </td>

                        <td class="px-6 py-4 font-semibold text-violet-600">
                            Rp {{ number_format($item->nominal) }}
                        </td>

                        <td class="px-6 py-4 text-slate-400">
                            @if ($item->tanggal_bayar)
                                {{ \Carbon\Carbon::parse($item->tanggal_bayar)->format('d M Y') }}
                            @else
                                —
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            @if ($item->status == 'lunas')
                                <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs font-semibold">
                                    Lunas
                                </span>
                            @else
                                <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-semibold">
                                    Belum Bayar
                                </span>
                            @endif
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center text-slate-400">
                            Data pembayaran tidak ditemukan
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>