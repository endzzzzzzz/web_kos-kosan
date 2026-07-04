<?php

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\Pembayaran;
use Carbon\Carbon;

new #[Layout('layouts.admin')] class extends Component
{
    public $kamar;

    public $nama;
    public $nomor_hp;
    public $tanggal_masuk;

    public function mount($id)
    {
        $this->kamar = Kamar::findOrFail($id);
    }

    public function save()
    {
        $this->validate([
            'nama' => 'required',
            'nomor_hp' => 'required',
            'tanggal_masuk' => 'required',
        ]);

        if ($this->kamar->penghuni) {

            session()->flash(
                'error',
                'Kamar ini sudah memiliki penghuni.'
            );

            return;
        }

        $penghuni = Penghuni::create([
            'kamar_id' => $this->kamar->id,
            'nama' => $this->nama,
            'nomor_hp' => $this->nomor_hp,
            'tanggal_masuk' => $this->tanggal_masuk,
        ]);

        $this->kamar->update([
            'status' => 'terisi'
        ]);

        $tanggalMasuk = Carbon::parse(
            $this->tanggal_masuk
        );

        Pembayaran::create([
            'penghuni_id' => $penghuni->id,
            'bulan' => $tanggalMasuk->translatedFormat('F'),
            'tahun' => $tanggalMasuk->year,
            'nominal' => $this->kamar->informasiKamar->harga,
            'status' => 'belum_bayar',
        ]);

        return redirect('/admin/data_kamar');
    }
};

?>

<div class="p-6">

    <h1 class="text-3xl font-bold mb-6">
        Tambah Penghuni
    </h1>

    <div class="bg-white p-6 rounded-3xl shadow space-y-5">

        @if (session()->has('error'))

            <div class="bg-red-100 text-red-600 px-4 py-3 rounded-xl">

                {{ session('error') }}

            </div>

        @endif

        <div>

            <label class="block mb-2 font-medium">
                Kamar
            </label>

            <input
                type="text"
                value="{{ $kamar->nomor_kamar }}"
                disabled
                class="w-full border rounded-xl px-4 py-3 bg-gray-100">

        </div>

        <div>

            <label class="block mb-2 font-medium">
                Nama Penghuni
            </label>

            <input
                type="text"
                wire:model="nama"
                class="w-full border rounded-xl px-4 py-3">

        </div>

        <div>

            <label class="block mb-2 font-medium">
                Nomor HP
            </label>

            <input
                type="text"
                wire:model="nomor_hp"
                class="w-full border rounded-xl px-4 py-3">

        </div>

        <div>

            <label class="block mb-2 font-medium">
                Tanggal Masuk
            </label>

            <input
                type="date"
                wire:model="tanggal_masuk"
                class="w-full border rounded-xl px-4 py-3">

        </div>

        <button
            wire:click="save"
            class="bg-blue-600 text-white px-5 py-3 rounded-xl">

            Simpan

        </button>

        <a
            href="/admin/data_kamar"
            class="bg-blue-600 text-white px-5 py-3 rounded-xl">

            Batal
        </a>

    </div>

</div>