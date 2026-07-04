<?php

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\InformasiKamar;
use Livewire\WithFileUploads;

new #[Layout('layouts.admin')] class extends Component
{
    use WithFileUploads;

    public $nama_kamar;
    public $lantai;
    public $deskripsi;
    public $harga;
    public $gambars = [];

    public function save()
    {
        $this->validate([
            'nama_kamar' => 'required|min:3|max:50',
            'lantai' => 'required|numeric|min:1|max:5',
            'harga' => 'required|numeric|min:1|max:10000000',
            'deskripsi' => 'required|min:10|max:250',
            'gambars.*' => 'image|max:2048',
        ]);


        $kamar = InformasiKamar::create([
            'nama_kamar' => $this->nama_kamar,

            'slug' => str()->slug($this->nama_kamar),

            'lantai' => $this->lantai,

            'deskripsi' => $this->deskripsi,

            'harga' => $this->harga,

        ]);

        foreach ($this->gambars as $gambar) {

            $path = $gambar->store('kamar', 'public');

            $kamar->gambars()->create([
                'gambar' => $path,
            ]);
        }
        return redirect('/admin/informasi_kamar');
    }
};

?>

<div class="p-6">

    <h1 class="text-2xl font-bold mb-6">
        Tambah Informasi Kamar
    </h1>

   <div class="bg-white p-6 rounded-3xl shadow space-y-5">

        <!-- Nama Kamar -->
        <div>
            <label class="block mb-2 font-medium text-slate-700">
                Nama Kamar
            </label>

            <input
                type="text"
                wire:model="nama_kamar"
                class="w-full border border-slate-300 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#7FD6DA] focus:border-transparent">
        </div>

        <!-- Lantai -->
        <div>
            <label class="block mb-2 font-medium text-slate-700">
                Lantai
            </label>

            <input
                type="text"
                wire:model="lantai"
                class="w-full border border-slate-300 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#7FD6DA] focus:border-transparent">
        </div>

        <!-- Deskripsi -->
        <div>
            <label class="block mb-2 font-medium text-slate-700">
                Deskripsi
            </label>

            <input
                type="text"
                wire:model="deskripsi"
                class="w-full border border-slate-300 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#7FD6DA] focus:border-transparent">
        </div>

        <!-- Harga -->
        <div>
            <label class="block mb-2 font-medium text-slate-700">
                Harga
            </label>

            <input
                type="number"
                wire:model="harga"
                class="w-full border border-slate-300 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#7FD6DA] focus:border-transparent">
        </div>

        <!-- Gambar -->
        <div>
            <label class="block mb-2 font-medium text-slate-700">
                Gambar
            </label>

            <input
                type="file"
                wire:model="gambars"
                multiple
                class="w-full border border-slate-300 rounded-xl px-4 py-3 text-slate-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#7FD6DA] file:text-white hover:file:bg-[#5ec8cc]">
        </div>

        <!-- Buttons -->
        <div class="flex items-center gap-3">

            <button
                wire:click="save"
                class="bg-[#7FD6DA] hover:bg-[#5ec8cc] text-white text-sm px-4 py-2 rounded-xl font-semibold transition">

                Simpan
            </button>

            <a
                href="/admin/informasi_kamar"
                class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2 text-sm rounded-xl font-semibold transition">

                Batal
            </a>

        </div>

    </div>

</div>