<?php

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\InformasiKamar;
use App\Models\Kamar;

new #[Layout('layouts.admin')] class extends Component
{
    public $nomor_kamar;
    public $informasi_kamar_id;
    public $status = 'kosong';

    public function save()
    {
        $this->validate([
            'nomor_kamar' => 'required',
            'informasi_kamar_id' => 'required',
            'status' => 'required',
        ]);

        Kamar::create([
            'nomor_kamar' => $this->nomor_kamar,
            'informasi_kamar_id' => $this->informasi_kamar_id,
            'status' => $this->status,
        ]);

        return redirect('/admin/data_kamar');
    }

    public function render()
    {
        return view('livewire.pages.post.admin.tambah_data_kamar', [
            'jenisKamars' => InformasiKamar::orderBy('lantai')->get(),
        ]);
    }
};

?>

<div class="p-6">

    <h1 class="text-2xl font-bold mb-6">
        Tambah Kamar
    </h1>

    <div class="bg-white p-6 rounded-3xl shadow space-y-5">

        <!-- Nomor Kamar -->
        <div>
            <label class="block mb-2 font-medium text-slate-700">
                Nomor Kamar
            </label>

            <input
                type="text"
                wire:model="nomor_kamar"
                class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#7FD6DA] focus:border-transparent text-slate-700">
        </div>

        <!-- Jenis Kamar -->
        <div>
            <label class="block mb-2 font-medium text-slate-700">
                Jenis Kamar
            </label>

            <select
                wire:model="informasi_kamar_id"
                class="w-full border border-slate-300 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#7FD6DA] focus:border-transparent">

                <option value="" disabled selected>
                    Pilih Jenis Kamar
                </option>

                @foreach ($jenisKamars as $jenis)
                    <option value="{{ $jenis->id }}">
                        {{ $jenis->nama_kamar }} - Lantai {{ $jenis->lantai }}
                    </option>
                @endforeach

            </select>
        </div>

        <!-- Status -->
        <div>
            <label class="block mb-2 font-medium text-slate-700">
                Status
            </label>

            <select
                wire:model="status"
                class="w-full border border-slate-300 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#7FD6DA] focus:border-transparent">

                <option value="kosong">Kosong</option>
                <option value="terisi">Terisi</option>

            </select>
        </div>

        <!-- Buttons -->
        <div class="flex items-center gap-3">
            <button
                wire:click="save"
                class="flex items-center gap-2 bg-[#7FD6DA] hover:bg-[#5ec8cc] text-white text-sm font-semibold px-4 py-2 rounded-xl transition">

                Simpan
            </button>

            <a
                href="/admin/data_kamar"
                class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2 text-sm rounded-xl font-semibold transition">

                    Batal
            </a>
        </div>
    </div>

</div>