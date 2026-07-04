<?php

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Pengajuan;
use App\Models\Penghuni;
use App\Models\Kamar;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

new #[Layout('layouts.admin')] class extends Component
{
    public function render()
    {
        return view('pages/post.admin.konfirmasi', [
            'pengajuans' => Pengajuan::with(['user', 'kamar.informasiKamar'])
                ->latest()
                ->get()
        ]);
    }

    public function konfirmasi($id)
    {
        DB::transaction(function () use ($id) {

            $pengajuan = Pengajuan::with('kamar.informasiKamar')->lockForUpdate()->findOrFail($id);

            if ($pengajuan->status !== 'pending') return;

            // 1. approve pengajuan
            $pengajuan->update([
                'status'      => 'approved',
                'approved_at' => Carbon::now(),
            ]);

            // 2. buat penghuni
            Penghuni::firstOrCreate(
                [
                    'user_id'  => $pengajuan->user_id,
                    'kamar_id' => $pengajuan->kamar_id,
                ],
                [
                    'nama'          => $pengajuan->nama,
                    'no_hp'         => $pengajuan->no_hp,
                    'alamat_asal'   => $pengajuan->alamat ?? null,
                    'tanggal_masuk' => now(),
                    'status'        => 'pending_aktivasi',
                ]
            )->update(['status' => 'pending_aktivasi']);

            // 3. kamar jadi terisi
            Kamar::where('id', $pengajuan->kamar_id)
                ->where('status', 'kosong')
                ->update(['status' => 'terisi']);

            // 4. buat tagihan awal
            \App\Models\Pembayaran::create([
                'user_id'      => $pengajuan->user_id,
                'pengajuan_id' => $pengajuan->id,
                'nominal'      => $pengajuan->kamar->informasiKamar->harga,
                'bulan'        => Carbon::now()->format('F'),
                'tahun'        => Carbon::now()->format('Y'),
                'status'       => 'belum_bayar',
            ]);
        });
    }

    public function tolak($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        if ($pengajuan->status !== 'pending') return;

        $pengajuan->update(['status' => 'rejected']);
    }
};
?>

<div class="p-6">

    <h1 class="text-2xl font-bold mb-6">
        Konfirmasi Pengajuan
    </h1>

    <div class="space-y-4">

        @foreach($pengajuans as $pengajuan)

            <div class="bg-white p-5 rounded-2xl shadow-lg relative border border-slate-200">

                <!-- STATUS -->
                <div class="absolute top-4 right-4">
                    <span class="
                        px-3 py-1 rounded-full text-xs font-bold tracking-wide
                        {{ $pengajuan->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $pengajuan->status == 'approved' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $pengajuan->status == 'rejected' ? 'bg-red-100 text-red-700' : '' }}
                    ">
                        {{ strtoupper($pengajuan->status) }}
                    </span>
                </div>

                <!-- HEADER -->
                <div class="mb-4">
                    <h2 class="text-lg font-bold text-slate-800">
                        {{ $pengajuan->user->name ?? 'Unknown User' }}
                    </h2>
                    <p class="text-xs text-slate-400">
                        ID Booking: #{{ $pengajuan->id }}
                    </p>
                </div>

                <!-- DETAIL -->
                <div class="space-y-1 text-sm text-slate-800">
                    <p> <span class="font-medium text-slate-800">Nomor Kamar:  {{ $pengajuan->kamar->nomor_kamar ?? '-' }}</span></p>
                    <p> <span class="font-medium text-slate-800">{{ $pengajuan->kamar->informasiKamar->nama_kamar ?? '-' }}</span></p>
                    <p> <span class="font-medium text-slate-800">{{ $pengajuan->no_hp }}</span></p>
                </div>

                <!-- BUTTON -->
                @if($pengajuan->status == 'pending')
                    <div class="flex gap-2 mt-5">

                        <button 
                            wire:click="konfirmasi({{ $pengajuan->id }})"
                            class="px-4 py-1.5 bg-green-500 hover:bg-green-600 text-white rounded-lg text-xs font-semibold transition">
                            ✔ Konfirmasi
                        </button>

                        <button 
                            wire:click="tolak({{ $pengajuan->id }})"
                            class="px-4 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-lg text-xs font-semibold transition">
                            ✖ Tolak
                        </button>

                    </div>
                @else
                    <div class="mt-5 text-xs text-slate-400 italic">
                        Sudah diproses oleh admin
                    </div>
                @endif

            </div>

        @endforeach

    </div>

</div>