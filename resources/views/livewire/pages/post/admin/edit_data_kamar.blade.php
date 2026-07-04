<?php

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Kamar;
use App\Models\InformasiKamar;

new #[Layout('layouts.admin')] class extends Component
{
    public $nomor_kamar;
    public $informasi_kamar_id;
    public $status;

    public $kamar;

    public function mount($id)
    {
        $this->kamar = Kamar::findOrFail($id);

        $this->nomor_kamar = $this->kamar->nomor_kamar;
        $this->informasi_kamar_id = $this->kamar->informasi_kamar_id;
        $this->status = $this->kamar->status;
    }

    public function update()
    {
        $this->validate([
            'nomor_kamar' => 'required',
            'informasi_kamar_id' => 'required',
            'status' => 'required',
        ]);

        $this->kamar->update([
            'nomor_kamar' => $this->nomor_kamar,
            'informasi_kamar_id' => $this->informasi_kamar_id,
            'status' => $this->status,
        ]);

        return redirect('/admin/data_kamar');
    }

    public function render()
    {
        return view('livewire.pages.post.admin.edit_data_kamar', [
            'jenisKamars' => InformasiKamar::orderBy('lantai')->get()
        ]);
    }
};

?>

<div class="p-6">

    <h1 class="text-3xl font-bold mb-6">
        Edit Kamar
    </h1>

    <div class="bg-white p-6 rounded-3xl shadow space-y-5">

        <div>

            <label class="block mb-2 font-medium">
                Nomor Kamar
            </label>

            <input
                type="text"
                wire:model="nomor_kamar"
                class="w-full border border-slate-200 rounded-xl px-4 py-3">

        </div>

        <div>

            <label class="block mb-2 font-medium">
                Jenis Kamar
            </label>

            <select
                wire:model="informasi_kamar_id"
                class="w-full border border-slate-200 rounded-xl px-4 py-3">

                @foreach ($jenisKamars as $jenis)

                    <option value="{{ $jenis->id }}">
                        Lantai {{ $jenis->lantai }} - {{ $jenis->nama_kamar }}
                    </option>

                @endforeach

            </select>

        </div>

        <div>

            <label class="block mb-2 font-medium">
                Status
            </label>

            <select
                wire:model="status"
                class="w-full border border-slate-200 rounded-xl px-4 py-3">

                <option value="kosong">Kosong</option>
                <option value="terisi">Terisi</option>

            </select>

        </div>

        <div class="flex items-center gap-3">
            <button
                wire:click="update"
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