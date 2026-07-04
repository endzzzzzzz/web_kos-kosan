<?php

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Pembayaran;
use App\Models\Penghuni;
use App\Models\Kamar;
use Illuminate\Support\Facades\DB;

new #[Layout('layouts.admin')] class extends Component
{
    public $showModal = false;
    public $selectedPembayaran = null;
    public $previewBukti = null;
    public $search = '';

    public function openModal($id)
    {
        $this->selectedPembayaran = Pembayaran::with([
            'pengajuan.user',
            'pengajuan.kamar.informasiKamar'
        ])->findOrFail($id);

        $this->previewBukti = $this->selectedPembayaran->bukti_transfer;
        $this->showModal = true;
    }

    public function approve()
    {
        if (!$this->selectedPembayaran) return;

        DB::transaction(function () {

            $pembayaran = Pembayaran::lockForUpdate()
                ->findOrFail($this->selectedPembayaran->id);

            if ($pembayaran->status !== 'pending_verification') {
                return;
            }

            $pengajuan = $pembayaran->pengajuan;

            // 1. update pembayaran
            $pembayaran->update([
                'status' => 'lunas',
                'tanggal_bayar' => now(),
            ]);

            // 2. update pengajuan
            $pengajuan->update([
                'status' => 'paid',
            ]);

    
            // 3. status penghuni
            $penghuni = Penghuni::where('kamar_id', $pengajuan->kamar_id)
                ->where('status', 'pending_aktivasi')
                ->first();

            if ($penghuni) {
                $penghuni->update(['status' => 'aktif']);
            }

            // 4. update kamar
            Kamar::where('id', $pengajuan->kamar_id)
                ->where('status', 'kosong')
                ->update([
                    'status' => 'terisi'
                ]);
        });

        $this->resetModal();
        session()->flash('success', 'Pembayaran berhasil dikonfirmasi');
    }

    public function reject()
    {
        if (!$this->selectedPembayaran) return;

        DB::transaction(function () {

            $pembayaran = Pembayaran::findOrFail($this->selectedPembayaran->id);

            if ($pembayaran->status !== 'pending_verification') {
                return;
            }

            $pembayaran->update([
                'status' => 'ditolak',
            ]);

            $pembayaran->pengajuan->update([
                'status' => 'waiting_payment',
            ]);
        });

        $this->resetModal();
        session()->flash('error', 'Pembayaran ditolak');
    }

    private function resetModal()
    {
        $this->showModal = false;
        $this->selectedPembayaran = null;
        $this->previewBukti = null;
    }

    public function render()
    {
        return view('livewire.pages.post.admin.konfirmasi_bayar', [
            'pembayarans' => Pembayaran::with([
            'pengajuan.user',
            'pengajuan.kamar.informasiKamar'
        ])
        ->whereIn('status', [
            'pending_verification',
            'lunas',
            'ditolak'
        ])
        ->when($this->search, function ($query) {
            $query->whereHas('pengajuan', function ($q) {
                $q->where('nama', 'like', '%' . $this->search . '%');
            });
        })
        ->latest()
        ->get()
        ]);
    }
};
?>

<div class="p-6">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <div>
            <h1 class="text-2xl font-bold text-slate-800">Konfirmasi Pembayaran</h1>
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
    

    {{-- FLASH --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="space-y-2">

        @forelse($pembayarans as $item)

            <div class="bg-white shadow-lg rounded-xl px-4 py-3 flex justify-between items-center border border-slate-200">

                <div class="min-w-0">
                    <div class="font-semibold text-slate-800">
                        {{ $item->pengajuan->nama ?? '-' }}
                    </div>
                    <div class="text-xs text-slate-500">
                        Kamar {{ $item->pengajuan->kamar->nomor_kamar ?? '-' }}
                        • {{ strtoupper($item->metode_pembayaran) }}
                    </div>
                </div>

                <div class="flex items-center gap-3">

                    <div class="font-bold text-indigo-600 text-sm">
                        Rp {{ number_format($item->nominal, 0, ',', '.') }}
                    </div>

                    @if($item->status === 'lunas')
                        <span class="text-xs px-3 py-1 bg-green-100 text-green-700 rounded-lg">
                            LUNAS
                        </span>

                    @elseif($item->status === 'ditolak')
                        <span class="text-xs px-3 py-1 bg-red-100 text-red-700 rounded-lg">
                            DITOLAK
                        </span>

                    @else
                        <button
                            wire:click="openModal({{ $item->id }})"
                            class="text-xs px-3 py-2 bg-indigo-600 text-white rounded-lg">
                            Verifikasi
                        </button>
                    @endif

                </div>

            </div>

        @empty
            <div class="text-center text-slate-400 py-10">
                Belum ada pembayaran
            </div>
        @endforelse

    </div>

    {{-- MODAL --}}
    @if($showModal && $selectedPembayaran)
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center">

        <div class="bg-white w-[450px] rounded-2xl p-5">

            <div class="flex justify-between mb-4">
                <h2 class="font-bold">Verifikasi Pembayaran</h2>
                <button wire:click="resetModal">✕</button>
            </div>

            <img src="{{ asset('storage/'.$previewBukti) }}"
                 class="rounded-xl border mb-4">

            <div class="flex gap-2">
                <button wire:click="reject"
                        class="w-full bg-red-500 text-white py-2 rounded-lg">
                    Tolak
                </button>

                <button wire:click="approve"
                        class="w-full bg-green-500 text-white py-2 rounded-lg">
                    Approve
                </button>
            </div>

        </div>

    </div>
    @endif

</div>