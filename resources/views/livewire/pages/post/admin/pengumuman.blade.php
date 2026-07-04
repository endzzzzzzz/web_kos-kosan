<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Models\Pengumuman;

new #[Layout('layouts.admin')] class extends Component
{
    public string $judul = '';
    public string $isi = '';
    public ?int $editId = null;
    public bool $showForm = false;

    protected function rules(): array
    {
        return [
            'judul' => 'required|string|min:3|max:255',
            'isi'   => 'required|string|min:10',
        ];
    }

    public function bukaForm(): void
    {
        $this->reset(['judul', 'isi', 'editId']);
        $this->resetValidation();
        $this->showForm = true;
    }

    public function tutupForm(): void
    {
        $this->reset(['judul', 'isi', 'editId', 'showForm']);
        $this->resetValidation();
    }

    public function simpan(): void
    {
        $this->validate();

        if ($this->editId) {
            Pengumuman::find($this->editId)?->update([
                'judul' => $this->judul,
                'isi'   => $this->isi,
            ]);
            session()->flash('sukses', 'Pengumuman berhasil diperbarui.');
        } else {
            Pengumuman::create([
                'judul'   => $this->judul,
                'isi'     => $this->isi,
                'tanggal' => now(),
                'aktif'   => true,
            ]);
            session()->flash('sukses', 'Pengumuman berhasil ditambahkan.');
        }

        $this->tutupForm();
    }

    public function edit(int $id): void
    {
        $data = Pengumuman::findOrFail($id);
        $this->editId   = $id;
        $this->judul    = $data->judul;
        $this->isi      = $data->isi;
        $this->showForm = true;
    }

    public function toggle(int $id): void
    {
        $data = Pengumuman::find($id);
        if ($data) {
            $data->aktif = !$data->aktif;
            $data->save();
            session()->flash('sukses', 'Status pengumuman diperbarui.');
        }
    }

    public function delete(int $id): void
    {
        Pengumuman::find($id)?->delete();
        session()->flash('sukses', 'Pengumuman berhasil dihapus.');
    }

    public function with(): array
    {
        return [
            'pengumuman' => Pengumuman::latest()->get(),
        ];
    }
}; 
?>

<div class="p-6 space-y-5">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Pengumuman</h1>
            <p class="text-sm text-slate-500 mt-0.5">Kelola pengumuman yang tampil ke pengguna</p>
        </div>
        @if (!$showForm)
            <button
                wire:click="bukaForm"
                class="flex items-center gap-2 bg-[#7FD6DA] hover:bg-[#5ec8cc] text-white text-sm font-semibold px-4 py-2 rounded-xl transition">
                + Tambah Pengumuman
            </button>
        @endif
    </div>

    <!-- Flash message -->
    @if (session('sukses'))
        <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('sukses') }}
        </div>
    @endif

    <!-- Form Tambah / Edit -->
    @if ($showForm)
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <h2 class="font-semibold text-slate-700 mb-4">
                {{ $editId ? 'Edit Pengumuman' : 'Pengumuman Baru' }}
            </h2>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Judul</label>
                    <input
                        type="text"
                        wire:model="judul"
                        placeholder="Contoh: Libur Hari Raya Idul Fitri"
                        class="w-full px-4 py-2.5 rounded-xl border text-sm
                               @error('judul') border-red-400 bg-red-50 @else border-slate-200 @enderror
                               focus:outline-none focus:ring-2 focus:ring-[#7FD6DA]">
                    @error('judul')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Isi Pengumuman</label>
                    <textarea
                        wire:model="isi"
                        rows="4"
                        placeholder="Tuliskan isi pengumuman di sini..."
                        class="w-full px-4 py-2.5 rounded-xl border text-sm resize-none
                               @error('isi') border-red-400 bg-red-50 @else border-slate-200 @enderror
                               focus:outline-none focus:ring-2 focus:ring-[#7FD6DA]"></textarea>
                    @error('isi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-2 pt-1">
                    <button
                        wire:click="simpan"
                        wire:loading.attr="disabled"
                        wire:target="simpan"
                        class="bg-[#7FD6DA] hover:bg-[#5ec8cc] disabled:opacity-60 text-white text-sm font-semibold px-5 py-2 rounded-xl transition">
                        <span wire:loading.remove wire:target="simpan">{{ $editId ? 'Perbarui' : 'Simpan' }}</span>
                        <span wire:loading wire:target="simpan">Menyimpan...</span>
                    </button>
                    <button
                        wire:click="tutupForm"
                        class="text-sm font-medium text-slate-500 hover:text-slate-700 px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 transition">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Daftar Pengumuman -->
    <div class="space-y-3">
        @forelse ($pengumuman as $item)
            <div class="bg-white rounded-2xl p-5 shadow-lg border border-slate-200 {{ !$item->aktif ? 'opacity-60' : '' }}">

                <div class="flex items-start justify-between gap-3">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h2 class="font-semibold text-slate-800 truncate">{{ $item->judul }}</h2>
                            <span class="shrink-0 text-xs px-2 py-0.5 rounded-full font-medium
                                {{ $item->aktif ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $item->aktif ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-400 mt-0.5">
                            {{ $item->tanggal->translatedFormat('d F Y, H:i') }}
                        </p>
                    </div>
                </div>

                <p class="text-sm text-slate-600 mt-3 leading-relaxed">{{ $item->isi }}</p>

                <div class="flex gap-2 mt-4 pt-4 border-t border-slate-100">
                    <button
                        wire:click="toggle({{ $item->id }})"
                        class="text-xs font-medium px-3 py-1.5 rounded-lg border transition
                               {{ $item->aktif
                                   ? 'border-green-200 text-green-700 hover:bg-green-50'
                                   : 'border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                        {{ $item->aktif ? 'Nonaktifkan' : 'Aktifkan' }}
                    </button>

                    <button
                        wire:click="edit({{ $item->id }})"
                        class="text-xs font-medium px-3 py-1.5 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
                        Edit
                    </button>

                    <button
                        wire:click="delete({{ $item->id }})"
                        wire:confirm="Yakin ingin menghapus pengumuman ini?"
                        class="text-xs font-medium px-3 py-1.5 rounded-lg border border-red-200 text-red-600 hover:bg-red-50 transition ml-auto">
                        Hapus
                    </button>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl p-10 text-center border border-dashed border-slate-200">
                <p class="text-slate-400 text-sm">Belum ada pengumuman.</p>
                <button wire:click="bukaForm" class="mt-3 text-sm text-[#7FD6DA] hover:underline font-medium">
                    Buat pengumuman pertama →
                </button>
            </div>
        @endforelse
    </div>

</div>