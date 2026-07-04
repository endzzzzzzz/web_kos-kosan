<?php

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Pembayaran;

new #[Layout('layouts.customer')] class extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $step = 1;

    public $metode_pembayaran;
    public $bukti;

    public $pembayaran_id;
    public $pembayaran;

    public function render()
    {
        return view('pages.post.customer.pembayaran', [
            'pembayarans' => Pembayaran::with(['pengajuan.kamar.informasiKamar'])
                ->where('user_id', auth()->id())
                ->latest()
                ->get()
        ]);
    }

    public function openModal($id)
    {
        $this->pembayaran_id = $id;
        $this->pembayaran = Pembayaran::with(['pengajuan.kamar.informasiKamar'])->findOrFail($id);
        $this->showModal = true;
        $this->step = 1;
        $this->metode_pembayaran = null;
        $this->bukti = null;
    }

    public function submitPembayaran()
    {
        $this->validate([
            'metode_pembayaran' => 'required',
            'bukti' => 'required|image|max:2048',
        ]);

        $path = $this->bukti->store('bukti-transfer', 'public');

        Pembayaran::where('id', $this->pembayaran_id)->update([
            'metode_pembayaran' => $this->metode_pembayaran,
            'bukti_transfer'    => $path,
            'status'            => 'pending_verification',
            'tanggal_bayar'     => now(),
        ]);

        $this->reset();
        session()->flash('success', 'Pembayaran berhasil dikirim, menunggu verifikasi admin.');
    }
};
?>

<div class="min-h-screen bg-[white] p-20">

    <h1 class="text-3xl font-black text-slate-800 mb-8">
        Pembayaran Saya
    </h1>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl text-green-700 text-sm font-medium">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if($pembayarans->count() == 0)
        <div class="bg-white rounded-2xl p-10 text-center shadow-lg border border-slate-200">
            <p class="text-slate-500 font-semibold">
                Belum ada tagihan pembayaran
            </p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($pembayarans as $item)
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-200">
                    <div class="flex justify-between items-center mb-3 ">
                        <div>
                            <h2 class="text-lg font-bold text-slate-800">
                                {{ $item->pengajuan->kamar->informasiKamar->nama_kamar ?? '-' }}
                            </h2>
                            <p class="text-sm text-slate-500">
                                {{ $item->bulan }} {{ $item->tahun }}
                                • Kamar {{ $item->pengajuan->kamar->nomor_kamar ?? '-' }}
                            </p>
                        </div>

                        @if($item->status == 'belum_bayar')
                            <button
                                wire:click="openModal({{ $item->id }})"
                                class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg text-sm">
                                Bayar Sekarang
                            </button>

                        @elseif($item->status == 'pending_verification')
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-xs font-semibold">
                                Menunggu Verifikasi
                            </span>

                        @elseif($item->status == 'lunas')
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-semibold">
                                ✔ Lunas
                            </span>

                        @elseif($item->status == 'ditolak')
                            <button
                                wire:click="openModal({{ $item->id }})"
                                class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm">
                                Bayar Ulang
                            </button>
                        @endif
                    </div>

                    <p class="text-xl font-black text-indigo-600">
                        Rp {{ number_format($item->nominal, 0, ',', '.') }}
                    </p>
                </div>
            @endforeach
        </div>
    @endif

    {{-- MODAL --}}
    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="w-[420px] h-[520px] bg-white rounded-2xl shadow-2xl overflow-hidden relative flex flex-col">

            <button
                wire:click="$set('showModal', false)"
                class="absolute top-3 right-4 text-slate-400 hover:text-slate-700 text-xl z-10">
                ✕
            </button>

            <div class="p-4 border-b shrink-0">
                <h2 class="text-lg font-bold text-slate-800">Pembayaran</h2>
                <p class="text-xs text-slate-500">Selesaikan pembayaran</p>
            </div>

            <div class="p-5 space-y-4 flex-1 overflow-y-auto">

                @if($step == 1)
                    <p class="text-sm font-semibold text-slate-700">Pilih Metode Pembayaran</p>

                    <button wire:click="$set('metode_pembayaran', 'bri')"
                        class="w-full p-3 rounded-xl border transition duration-200
                        {{ $metode_pembayaran == 'bri' ? 'bg-blue-50 border-blue-500 scale-[1.02]' : 'hover:bg-slate-50' }}">
                        Transfer Bank BRI
                    </button>

                    <button wire:click="$set('metode_pembayaran', 'dana')"
                        class="w-full p-3 rounded-xl border transition duration-200
                        {{ $metode_pembayaran == 'dana' ? 'bg-blue-50 border-blue-500 scale-[1.02]' : 'hover:bg-slate-50' }}">
                        E-Wallet DANA
                    </button>

                    <button wire:click="$set('step', 2)"
                        @if(!$metode_pembayaran) disabled @endif
                        class="w-full mt-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-xl active:scale-95 transition
                        {{ !$metode_pembayaran ? 'opacity-50 cursor-not-allowed' : '' }}">
                        Lanjut
                    </button>
                @endif

                @if($step == 2)
                    <div class="p-4 rounded-xl bg-slate-50 border text-sm space-y-2">
                        @if($metode_pembayaran == 'bri')
                            <p class="font-bold">Transfer Bank BRI</p>
                            <p>No Rek: 1234567890</p>
                            <p>a.n: Kos di-Kos</p>
                        @elseif($metode_pembayaran == 'dana')
                            <p class="font-bold">E-Wallet DANA</p>
                            <p>No: 0812-xxxx-xxxx</p>
                        @endif

                        <div class="mt-3 p-3 bg-white rounded-lg border">
                            <p class="text-xs text-slate-500">Total Pembayaran</p>
                            <p class="text-lg font-bold text-slate-800">
                                Rp {{ number_format($pembayaran->nominal ?? 0, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <button wire:click="$set('step', 3)"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-xl active:scale-95 transition">
                        Sudah Transfer
                    </button>
                @endif

                @if($step == 3)
                    <p class="text-sm font-semibold text-slate-700">Upload Bukti Pembayaran</p>

                    <input type="file" wire:model="bukti"
                        class="w-full border rounded-xl p-2 bg-slate-50 text-sm">

                    @error('bukti')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror

                    <button wire:click="submitPembayaran"
                        class="w-full bg-green-500 hover:bg-green-600 text-white p-2 rounded-xl active:scale-95 transition">
                        Kirim Bukti Pembayaran
                    </button>
                @endif

            </div>
        </div>
    </div>
    @endif

</div>