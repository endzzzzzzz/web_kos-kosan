<?php

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Penghuni;

new #[Layout('layouts.admin')] class extends Component
{
    public $penghuni;

    public $nama;
    public $nomor_hp;
    public $tanggal_masuk;

    public function mount($id)
    {
        $this->penghuni = Penghuni::findOrFail($id);

        $this->nama = $this->penghuni->nama;
        $this->nomor_hp = $this->penghuni->nomor_hp;
        $this->tanggal_masuk = $this->penghuni->tanggal_masuk;
    }

    public function update()
    {
        $this->validate([
            'nama' => 'required',
            'nomor_hp' => 'required',
            'tanggal_masuk' => 'required',
        ]);

        $this->penghuni->update([
            'nama' => $this->nama,
            'nomor_hp' => $this->nomor_hp,
            'tanggal_masuk' => $this->tanggal_masuk,
        ]);

        return redirect('/admin/data_kamar');
    }

    public function render()
    {
        return view(
            'livewire.pages.post.admin.edit_penghuni_kamar'
        );
    }
};

?>

<div class="p-6">

    <div class="max-w-2xl mx-auto">

        <div class="mb-6">

            <h1 class="text-2xl font-bold">
                Edit Penghuni
            </h1>

        </div>

        <div class="bg-white p-6 rounded-3xl shadow space-y-5">

            <div>

                <label class="block mb-2">
                    Nama
                </label>

                <input
                    type="text"
                    wire:model="nama"
                    class="w-full border rounded-xl px-4 py-3">

            </div>

            <div>

                <label class="block mb-2">
                    Nomor HP
                </label>

                <input
                    type="text"
                    wire:model="nomor_hp"
                    class="w-full border rounded-xl px-4 py-3">

            </div>

            <div>

                <label class="block mb-2">
                    Tanggal Masuk
                </label>

                <input
                    type="date"
                    wire:model="tanggal_masuk"
                    class="w-full border rounded-xl px-4 py-3">

            </div>

            <button
                wire:click="update"
                class="bg-blue-600 text-white px-5 py-3 rounded-xl">

                Simpan

            </button>

        </div>

    </div>

</div>