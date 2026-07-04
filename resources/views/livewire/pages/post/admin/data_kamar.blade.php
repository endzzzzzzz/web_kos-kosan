<?php

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\Pembayaran;
use Carbon\Carbon;

new #[Layout('layouts.admin')] class extends Component
{
    public $search = '';

    public function render()
    {
        $kamars = Kamar::with([
                'informasiKamar',
                'penghuni.pembayaranBelumLunas'
            ])
            ->where('nomor_kamar', 'like', '%' . $this->search . '%')
            ->get()
            ->sortBy(fn($k) => $k->informasiKamar->lantai)
            ->groupBy(fn($k) => 'Lantai ' . $k->informasiKamar->lantai);

        return view('livewire.pages.post.admin.data_kamar', [
            'kamars' => $kamars
        ]);
    }

    public function delete($id)
    {
        Kamar::findOrFail($id)->delete();
    }

    public function kosongkanKamar($id)
    {
        $kamar = Kamar::findOrFail($id);

        if ($kamar->penghuni) {
            $kamar->penghuni->update([
                'status' => 'dibatalkan'
            ]);
        }

        $kamar->update([
            'status' => 'kosong'
        ]);
    }

    public function mount()
    {
        $this->generateTagihanBulanan();
    }

    public function generateTagihanBulanan()
    {
        $bulan = Carbon::now()->format('F');
        $tahun = Carbon::now()->format('Y');

        $penghunis = Penghuni::with('kamar.informasiKamar')
            ->where('status', 'aktif')
            ->get();

        foreach ($penghunis as $penghuni) {

            $pengajuan = \App\Models\Pengajuan::where('user_id', $penghuni->user_id)
                ->where('kamar_id', $penghuni->kamar_id)
                ->first();

            if (!$pengajuan) continue;

            $exists = Pembayaran::where('pengajuan_id', $pengajuan->id)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->exists();

            if (!$exists) {
                Pembayaran::create([
                    'user_id'      => $penghuni->user_id,
                    'pengajuan_id' => $pengajuan->id,
                    'nominal'      => $penghuni->kamar->informasiKamar->harga,
                    'bulan'        => $bulan,
                    'tahun'        => $tahun,
                    'status'       => 'belum_bayar',
                ]);
            }
        }
        $penghunis = Penghuni::with('kamar.informasiKamar')
        ->where('status', 'aktif')
        ->where('tanggal_masuk', '<', Carbon::now()->startOfMonth()) // ← tambah ini
        ->get();
    }
};
?>

<div class="p-6">

    <div class="flex justify-between items-center mb-6 ">

        <div>
            <h1 class="text-2xl font-bold">Kelola Kamar</h1>
            <p class="text-gray-500">Data semua kamar kos</p>
        </div>

        <a href="{{ route('admin.tambah_data_kamar') }}"
           class="flex items-center gap-2 bg-[#7FD6DA] hover:bg-[#5ec8cc] text-white text-sm font-semibold px-4 py-2 rounded-xl transition">
            + Tambah Kamar
        </a>
        
        

    </div>

    <div class="mb-8">
        <div class="mb-8">

        <input
            type="text"
            wire:model.live="search"
            placeholder="Cari nomor kamar..."
            class="w-full rounded-2xl px-5 py-3 shadow
            bg-white/60 focus:bg-[#7FD6DA]/10
            outline-none transition"
            />

    </div>
    </div>

    @foreach ($kamars as $lantai => $items)

        <div class="mb-10">

            <div class="flex items-center gap-4 mb-5">
                <h2 class="text-2xl font-bold">{{ $lantai }}</h2>
                <div class="h-px bg-gray-300 flex-1"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-6 gap-3">

                @foreach ($items as $item)

                    @php
                        $penghuni = $item->penghuni;
                        $pembayaran = $penghuni?->pembayaranBelumLunas;
                    @endphp

                    <div class="bg-white rounded-xl shadow-lg p-3 border border-slate-200">

                        {{-- HEADER --}}
                        <div class="flex justify-between items-start mb-3">

                            <div>
                                <h2 class="text-2xl font-bold">
                                    {{ $item->nomor_kamar }}
                                </h2>

                                <p class="text-sm text-gray-500">
                                    {{ $item->penghuni ? 'Terisi' : 'Kosong' }}
                                </p>
                            </div>

                            <div x-data="{ open: false }" class="relative inline-block">

                        <!-- BUTTON 3 DOT -->
                        <button
                            @click="open = !open"
                            class="px-2 py-1 rounded-lg hover:bg-slate-100 text-lg font-bold">
                            ⋮
                        </button>

                        <!-- DROPDOWN -->
                        <div
                            x-show="open"
                            @click.away="open = false"
                            x-transition
                            class="absolute right-0 bottom-full mb-2 w-44 bg-white border border-slate-200 rounded-xl shadow-lg z-50 overflow-hidden">
                            

                            @if ($penghuni)

                                <a href="{{ route('admin.lihat_penghuni_kamar', $item->id) }}"
                                class="block px-4 py-2 text-sm hover:bg-slate-100">
                                    Lihat Penghuni
                                </a>

                                <button
                                    wire:click="kosongkanKamar({{ $item->id }})"
                                    class="w-full text-left px-4 py-2 text-sm hover:bg-slate-100">
                                    Kosongkan Kamar
                                </button>

                                <a href="/admin/histori_pembayaran?search={{ $penghuni->nama }}"
                                class="block px-4 py-2 text-sm hover:bg-slate-100">
                                    Histori Pembayaran
                                </a>

                            @else

                                <a href="/admin/edit_data_kamar/{{ $item->id }}"
                                class="block px-4 py-2 text-sm hover:bg-slate-100">
                                    Edit Kamar
                                </a>

                                <button
                                    wire:click="delete({{ $item->id }})"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    Hapus
                                </button>

                            @endif

                        </div>
                    </div>

                        </div>

                        {{-- INFO PENGHUNI --}}
                        <div class="space-y-2">

                            <div>
                                <p class="text-xs text-gray-400">Penghuni</p>
                                <p class="font-semibold">
                                    {{ $item->penghuni?->nama ?? '-' }}
                                </p>
                            </div>

                            {{-- PEMBAYARAN --}}
                            <div>

                                <p class="text-xs text-gray-400">Pembayaran</p>

                                @if ($penghuni)

                                    @if ($pembayaran)

                                        <span class="inline-block bg-red-100 text-red-600 text-xs px-2 py-1 rounded-full">
                                            Belum Bayar {{ $pembayaran->bulan }} {{ $pembayaran->tahun }}
                                        </span>

                                    @else

                                        <span class="inline-block bg-green-100 text-green-600 text-xs px-2 py-1 rounded-full">
                                            Lunas
                                        </span>

                                    @endif

                                @else

                                    <span class="inline-block bg-gray-100 text-gray-500 text-xs px-2 py-1 rounded-full">
                                        Kosong
                                    </span>

                                @endif

                            </div>

                            {{-- TAGIHAN --}}
                            <div>
                                <p class="text-xs text-gray-400">Tagihan</p>
                                <p class="text-lg font-bold text-violet-600">
                                    Rp {{ number_format($item->informasiKamar->harga) }}
                                </p>
                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    @endforeach

</div>