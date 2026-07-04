<?php

use App\Models\InformasiKamar;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\GambarKamar;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

new #[Layout('layouts.admin')] class extends Component
{
    use WithFileUploads;

    public $nama_kamar;
    public $lantai;
    public $harga;
    public $deskripsi;
    public $gambars = [];
    public $kamar;

    public function mount($id)
    {
        $this->kamar = InformasiKamar::findOrFail($id);

        $this->nama_kamar = $this->kamar->nama_kamar;
        $this->lantai = $this->kamar->lantai;
        $this->deskripsi = $this->kamar->deskripsi;
        $this->harga = $this->kamar->harga;
    }

    public function update()
    {   
       
        $this->validate([
            'nama_kamar' => 'required|min:3|max:50',
            'lantai' => 'required|numeric|min:1|max:5',
            'harga' => 'required|numeric|min:1|max:10000000',
            'deskripsi' => 'required|min:10|max:250',
            'gambars' => 'nullable|array',
            'gambars.*' => 'image|max:5000',
        ]);

        $this->kamar->update([
            'nama_kamar' => $this->nama_kamar,
            'slug' => str()->slug($this->nama_kamar),
            'lantai' => $this->lantai,
            'deskripsi' => $this->deskripsi,
            'harga' => $this->harga,
        ]);

        foreach ($this->gambars as $gambar) {

            $path = $gambar->store('kamar', 'public');
            
            $this->kamar->gambars()->create([
                'gambar' => $path,
            ]);
        }

        return redirect('/admin/informasi_kamar');
    }

    public function hapusGambar($id)
    {
        $gambar = GambarKamar::findOrFail($id);

        if (
            $gambar->gambar &&
            Storage::disk('public')->exists($gambar->gambar)
        ) {
            Storage::disk('public')->delete($gambar->gambar);
        }

        $gambar->delete();
    }
};

?>

<div class="p-6">

    <h1 class="text-2xl font-bold mb-6">
        Edit Informasi Kamar
    </h1>
    
        <div class="bg-white p-6 rounded-3xl shadow space-y-5">

            <div>
                <label class="block mb-2 font-medium">
                    Nama Kamar
                </label>

                <input
                    type="text"
                    wire:model="nama_kamar"
                    class="w-full border border-slate-200 rounded-xl px-4 py-3">
            </div>

            <div>
                <label class="block mb-2 font-medium">
                    Lantai
                </label>

                <input
                    type="text"
                    wire:model="lantai"
                    class="w-full border border-slate-200 rounded-xl px-4 py-3">
            </div>

            <div>
                <label class="block mb-2 font-medium">
                    Deskripsi
                </label>

                <input
                    type="text"
                    wire:model="deskripsi"
                    class="w-full border border-slate-200 rounded-xl px-4 py-3">
            </div>

            <div>
                <label class="block mb-2 font-medium">
                    Harga
                </label>

                <input
                    type="number"
                    wire:model="harga"
                    class="w-fullborder border-slate-200 rounded-xl px-4 py-3">
            </div>

            <div>
                <label class="block mb-2 font-medium">
                    Gambar
                </label>

                <input
                    type="file"
                    wire:model="gambars"
                    multiple
                    class="w-full border border-slate-200 rounded-xl px-4 py-3">

                <div wire:loading wire:target="gambars" class="text-sm text-gray-500 mt-1">
                    Sedang mengupload, tunggu...
                </div>
            </div>

            <div class="flex gap-3 flex-wrap mt-4">

                @foreach ($this->kamar->gambars as $existgambar)
                    <div class="relative">
                        <img
                            src="{{ asset('storage/' . $existgambar->gambar) }}"
                            class="w-32 h-32 object-cover rounded-xl">

                        <button
                            type="button"
                            wire:click="hapusGambar({{ $existgambar->id }})"
                            class="absolute top-1 right-1 backdrop-blur-md bg-white/30 text-white w-6 h-6 rounded-full text-sm border border-white/20">
                            ✕
                        </button>
                    </div>
                @endforeach

            </div>
        

            <div class="flex items-center gap-3">
                <button
                    wire:click="update"
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

</div>