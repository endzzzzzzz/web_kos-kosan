<?php

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\InformasiKamar;
use App\Models\Kamar;
use App\Models\Pengajuan;

new #[Layout('layouts.customer')] class extends Component
{
    public $showModal = false;

    public $kamarDipilih = null;

    public $daftarKamar = [];

    public $nama = '';
    public $no_hp = '';
    public $alamat_asal = '';

    public InformasiKamar $informasiKamar;

    public function mount($id)
    {
        $this->informasiKamar = InformasiKamar::findOrFail($id);

        $this->daftarKamar = Kamar::where('informasi_kamar_id', $this->informasiKamar->id)
            ->get();
    }

    public function bukaModalKamar()
    {
        $this->showModal = true;
    }

    public function pilihKamar($id)
    {
        $kamar = Kamar::findOrFail($id);

        if ($kamar->status !== 'kosong') {
            return;
        }

        $this->kamarDipilih = $kamar;
        $this->showModal = false;
    }

    public function ajukanPemesanan()
    {
        if (!$this->kamarDipilih) {
            $this->dispatch('notify', 'Pilih kamar dulu');
            return;
        }

        $kamar = Kamar::find($this->kamarDipilih->id);

        if (!$kamar || $kamar->status !== 'kosong') {
            $this->dispatch('notify', 'Kamar sudah terisi');
            return;
        }

        Pengajuan::create([
            'user_id' => auth()->id(),
            'kamar_id' => $kamar->id,
            'nama' => $this->nama,
            'no_hp' => $this->no_hp,
            'alamat_asal' => $this->alamat_asal,
            'status' => 'pending',
        ]);

        $this->reset(['nama', 'no_hp', 'alamat_asal', 'kamarDipilih']);

        return redirect()->route('customer.booking');
    }
};
?>

<div class="min-h-screen bg-[white]">
    <div class="max-w-4xl mx-auto px-6 py-10">

        <h1 class="text-4xl font-black text-[#C97B63] mb-8">
            Pengajuan Pemesanan
        </h1>

        <div class="bg-white rounded-3xl p-8 shadow-lg">

            <h2 class="text-2xl font-bold">
                {{ $informasiKamar->nama_kamar }}
            </h2>

            <p class="mt-2 text-slate-500">
                {{ $informasiKamar->deskripsi }}
            </p>

            <p class="mt-4 text-3xl font-black text-[#54D8E3]">
                Rp {{ number_format($informasiKamar->harga, 0, ',', '.') }}
            </p>


            <form class="mt-8" wire:submit.prevent="ajukanPemesanan">

                {{-- Nomor kamar --}}
                <div class="mb-5">
                    <label class="block mb-2 font-semibold">
                        Nomor Kamar
                    </label>

                    <button
                        type="button"
                        wire:click="bukaModalKamar"
                        class="
                            w-full rounded-2xl p-3 text-left transition-all duration-200

                            {{ $kamarDipilih
                                ? 'bg-[#9de6e9] text-white'
                                : 'bg-[#FFF8F3] text-slate-700'
                            }}
                        ">

                        @if($kamarDipilih)

                            <div class="flex items-center justify-between">
                                <span>{{ $kamarDipilih->nomor_kamar }}</span>
                                <span>✓</span>
                            </div>

                        @else

                            Pilih Nomor Kamar

                        @endif

                    </button>
                </div>

                {{-- Nama --}}
                <div class="mb-5">
                    <label class="block mb-2 font-semibold">
                        Nama Lengkap
                    </label>

                    <input
                    type="text"
                    wire:model.live="nama"
                    class="bg-[#FFF8F3] w-full rounded-2xl p-3 transition-all duration-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#54D8E3]">
                </div>

                {{-- No HP --}}
                <div class="mb-5">
                    <label class="block mb-2 font-semibold">
                        Nomor HP
                    </label>

                    <input
                        type="text"
                        wire:model.live="no_hp"
                        class="bg-[#FFF8F3] w-full rounded-2xl p-3 transition-all duration-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#54D8E3]">
                </div>

                {{-- Alamat --}}
                <div class="mb-5">
                    <label class="block mb-2 font-semibold">
                        Alamat
                    </label>

                   <textarea
                        rows="4"
                        wire:model.live="alamat_asal"
                        class="bg-[#FFF8F3] w-full rounded-2xl p-3 resize-none border-0 outline-none transition-all duration-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#54D8E3]"
                    ></textarea>
                </div>

                <div class="flex justify-end gap-3 mt-8">

                    <a
                        href="{{ route('customer.kamar') }}"
                        class="px-6 py-3 rounded-2xl bg-slate-100 text-slate-600 font-bold hover:bg-slate-200 transition"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="px-6 py-3 rounded-2xl bg-[#ffb453] text-white font-bold hover:brightness-105 transition"
                    >
                        Ajukan Pemesanan
                    </button>

                </div>

            </form>
        </div>


    </div>

    @if($showModal)

        <div class="fixed inset-0 bg-black/20 backdrop-blur-sm z-50 flex items-center justify-center p-6">

            <div class="w-full max-w-5xl h-[70vh] rounded-[30px] bg-white shadow-2xl border border-slate-100 overflow-hidden">

                <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between">

                    <div>
                        <h2 class="text-2xl font-black text-slate-800">
                            Pilih Nomor Kamar
                        </h2>

                        <p class="text-sm text-slate-500 mt-1">
                            {{ $informasiKamar->nama_kamar }}
                        </p>
                    </div>

                    <button
                        wire:click="$set('showModal', false)"
                        class="w-10 h-10 rounded-full bg-slate-100 hover:bg-slate-200 transition"
                    >
                        ✕
                    </button>

                </div>

                <div class="p-8 overflow-y-auto h-[calc(70vh-80px)]">

                    <div class="grid grid-cols-3 md:grid-cols-5 lg:grid-cols-7 gap-3">

                        @foreach($daftarKamar as $kamar)

                            <div

                                @if($kamar->status === 'kosong')
                                    wire:click="pilihKamar({{ $kamar->id }})"
                                @endif

                                class="
                                    group
                                    rounded-2xl
                                    p-4
                                    text-center
                                    transition-all
                                    duration-300

                                    {{ $kamar->status === 'kosong'
                                        ? 'cursor-pointer bg-[#FFF8F3] shadow-md hover:shadow-xl hover:-translate-y-1'
                                        : 'bg-slate-100 opacity-70'
                                    }}
                                "
                            >

                                <div class="text-lg font-black text-slate-800">
                                    {{ $kamar->nomor_kamar }}
                                </div>

                                <div class="mt-2">

                                    @if($kamar->status === 'kosong')

                                        <span class="inline-flex items-center rounded-full bg-green-100 px-2 py-1 text-[11px] font-bold text-green-700">
                                            Kosong
                                        </span>

                                    @else

                                        <span class="inline-flex items-center rounded-full bg-red-100 px-2 py-1 text-[11px] font-bold text-red-700">
                                            Terisi
                                        </span>

                                    @endif

                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>

        </div>

    @endif
</div>