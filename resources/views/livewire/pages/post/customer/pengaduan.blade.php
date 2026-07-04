<?php

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Pengaduan;
use App\Models\Penghuni;

new #[Layout('layouts.customer')] class extends Component
{
    public $judul = '';
    public $kategori = '';
    public $deskripsi = '';

    public $showForm = false;

    public function simpan()
    {
        $this->validate([
            'judul' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'required',
        ]);

        $penghuni = Penghuni::where('user_id', auth()->id())->first();

        Pengaduan::create([
            'penghuni_id' => $penghuni->id,
            'judul' => $this->judul,
            'kategori' => $this->kategori,
            'deskripsi' => $this->deskripsi,
            'status' => 'pending',
        ]);

        $this->reset([
            'judul',
            'kategori',
            'deskripsi'
        ]);

        $this->showForm = false;

        session()->flash('success', 'Pengaduan berhasil dikirim');
    }

    public function render()
    {
        $penghuni = Penghuni::where('user_id', auth()->id())->first();

        return view('pages.post.customer.pengaduan', [
            'pengaduans' => Pengaduan::where('penghuni_id', $penghuni->id)
                ->latest()
                ->get()
        ]);
    }

    public function hapus($id)
    {
        $penghuni = Penghuni::where('user_id', auth()->id())->first();

        Pengaduan::where('id', $id)
            ->where('penghuni_id', $penghuni->id)
            ->delete();

        session()->flash('success', 'Pengaduan berhasil dibatalkan');
    }
};

?>

<div class="min-h-screen bg-[white] p-20">

    @if (session()->has('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-8">

        <h1 class="text-3xl font-bold">
            Riwayat Pengaduan
        </h1>

        <button
            wire:click="$toggle('showForm')"
            class="bg-cyan-500 text-white px-5 py-3 rounded-xl font-semibold">

            {{ $showForm ? 'Tutup Form' : 'Ajukan Pengaduan' }}

        </button>

    </div>

    @if($showForm)

        <div class="bg-white rounded-2xl p-6 mb-8">

            <input
                type="text"
                wire:model="judul"
                placeholder="Judul Pengaduan"
                class="w-full p-3 rounded-xl mb-4 bg-slate-100">

            <select
                wire:model="kategori"
                class="w-full p-3 rounded-xl mb-4 bg-slate-100">

                <option value="">Pilih Kategori</option>
                <option value="listrik">Listrik</option>
                <option value="kebersihan">Kebersihan</option>
                <option value="kerusakan">Kerusakan</option>
                <option value="keamanan">Keamanan</option>
                <option value="lainnya">Lainnya</option>

            </select>

            <textarea
                wire:model="deskripsi"
                rows="5"
                placeholder="Deskripsi Pengaduan"
                class="w-full p-3 rounded-xl bg-slate-100"></textarea>

            <button
                wire:click="simpan"
                class="mt-4 bg-cyan-500 text-white px-5 py-3 rounded-xl">

                Kirim Pengaduan

            </button>

        </div>

    @endif

    @forelse($pengaduans as $pengaduan)

        <div class="bg-white rounded-2xl p-5 mb-4 shadow-lg">

            <div class="flex justify-between items-center mb-2">

                <h3 class="font-bold text-lg">
                    {{ $pengaduan->judul }}
                </h3>

                <div class="flex items-center gap-2">

                    <span class="
                        px-3 py-1 rounded-full text-xs font-bold
                        {{ $pengaduan->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $pengaduan->status == 'diproses' ? 'bg-blue-100 text-blue-700' : '' }}
                        {{ $pengaduan->status == 'selesai' ? 'bg-green-100 text-green-700' : '' }}
                    ">
                        {{ strtoupper($pengaduan->status) }}
                    </span>

                    @if($pengaduan->status == 'pending')
                        <button
                            wire:click="hapus({{ $pengaduan->id }})"
                            wire:confirm="Yakin ingin membatalkan pengaduan ini?"
                            class="w-7 h-7 rounded-full font-bold hover:bg-red-200">

                            ✕

                        </button>
                    @endif

                </div>

            </div>

            <p class="text-sm text-slate-500 mb-2">
                {{ ucfirst($pengaduan->kategori) }}
            </p>

            <p class="text-slate-700">
                {{ $pengaduan->deskripsi }}
            </p>

            @if($pengaduan->catatan_admin)
                <div class="mt-4 p-3 bg-slate-100 rounded-xl">
                    <p class="font-semibold text-sm mb-1">
                        Catatan Admin
                    </p>
                    <p class="text-sm text-slate-600">
                        {{ $pengaduan->catatan_admin }}
                    </p>
                </div>
            @endif

        </div>

    @empty

        <div class="bg-white rounded-2xl p-10 text-center text-slate-500 shadow-lg border border-slate-200">
            Belum ada pengaduan
        </div>

    @endforelse

</div>