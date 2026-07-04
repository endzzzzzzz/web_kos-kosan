<?php

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Pengaduan;

new #[Layout('layouts.admin')] class extends Component
{
    public function ubahStatus($id, $status)
    {
        Pengaduan::findOrFail($id)->update([
            'status' => $status
        ]);
    }

    public function render()
    {
        return view('pages.post.admin.daftar_pengaduan', [
            'pengaduans' => Pengaduan::with([
                'penghuni',
                'penghuni.kamar'
            ])
            ->latest()
            ->get()
        ]);
    }

    public function hapus($id)
    {
        Pengaduan::findOrFail($id)->delete();
    }
};

?>

<div class="p-6">

    <h1 class="text-2xl font-bold mb-6">
        Daftar Pengaduan Penghuni
    </h1>

    @forelse($pengaduans as $pengaduan)

        <div class="bg-white rounded-2xl p-6 mb-4 shadow-sm">

            <div class="flex justify-between items-start mb-4">

                <div>

                    <h2 class="font-bold text-lg">
                        {{ $pengaduan->judul }}
                    </h2>

                    <p class="text-sm text-slate-500">
                        {{ $pengaduan->penghuni->nama }}
                    </p>

                    <p class="text-sm text-slate-500">
                        Kamar:
                        {{ $pengaduan->penghuni->kamar->nomor_kamar ?? '-' }}
                    </p>

                </div>

                <span class="
                    px-3 py-1 rounded-full text-xs font-bold
                    {{ $pengaduan->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                    {{ $pengaduan->status == 'diproses' ? 'bg-blue-100 text-blue-700' : '' }}
                    {{ $pengaduan->status == 'selesai' ? 'bg-green-100 text-green-700' : '' }}
                ">
                    {{ strtoupper($pengaduan->status) }}
                </span>

            </div>

            <p class="text-sm text-slate-500 mb-2">
                Kategori:
                {{ ucfirst($pengaduan->kategori) }}
            </p>

            <p class="mb-4">
                {{ $pengaduan->deskripsi }}
            </p>

            @if($pengaduan->catatan_admin)

                <div class="bg-slate-100 rounded-xl p-3 mb-4">

                    <p class="font-semibold text-sm mb-1">
                        Catatan Admin
                    </p>

                    <p class="text-sm text-slate-600">
                        {{ $pengaduan->catatan_admin }}
                    </p>
                </div>

            @endif

            <div class="flex gap-2">

                @if($pengaduan->status == 'pending')

                    <button
                        wire:click="ubahStatus({{ $pengaduan->id }}, 'diproses')"
                        class="px-4 py-2 bg-blue-500 text-white rounded-xl">

                        Diproses

                    </button>

                @endif

                @if($pengaduan->status != 'selesai')

                    <button
                        wire:click="ubahStatus({{ $pengaduan->id }}, 'selesai')"
                        class="px-4 py-2 bg-green-500 text-white rounded-xl">

                        Selesai

                    </button>

                @endif

                <button
                    wire:click="hapus({{ $pengaduan->id }})"
                    wire:confirm="Yakin ingin menghapus pengaduan ini?"
                    class="px-4 py-2 bg-red-400 text-white rounded-xl">
                    Hapus
                </button>
            </div>
        </div>

    @empty

        <div class="bg-white rounded-2xl p-10 text-center text-slate-500 shadow-lg">

            Belum ada pengaduan

        </div>

    @endforelse

</div>