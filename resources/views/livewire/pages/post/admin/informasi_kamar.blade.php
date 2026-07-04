<?php

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\InformasiKamar;
use Livewire\WithPagination;
use App\Models\GambarKamar;
use Illuminate\Support\Facades\Storage;


new #[Layout('layouts.admin')] class extends Component
{
    public function render()
    {
        return view('livewire.pages.post.admin.informasi_kamar', [
            'kamars' => InformasiKamar::where(
                'nama_kamar',
                'like',
                '%' . $this->search . '%'
            )->orderBy('lantai')->paginate(5)
        ]);
    }

    public $search = '';
    use WithPagination;
    
    public function gambars()
    {
        return $this->hasMany(GambarKamar::class);
    }

    public function delete($id)
    {
        $kamar = InformasiKamar::findOrFail($id);

        foreach ($kamar->gambars as $gambar) {

            if (
                $gambar->gambar &&
                Storage::disk('public')->exists($gambar->gambar)
            ) {
                Storage::disk('public')->delete($gambar->gambar);
            }

            $gambar->delete();
        }

        $kamar->delete();
    }
};

?>

<div class="p-6">
    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-2xl font-bold">
                Kelola Kamar
            </h1>

            <p class="text-gray-500">
                Data jenis kamar kos
            </p>
        </div>

        <a href="{{ route('admin.tambah_informasi_kamar') }}" 
            class="flex items-center gap-2 bg-[#7FD6DA] hover:bg-[#5ec8cc] text-white text-sm font-semibold px-4 py-2 rounded-xl transition">
            + Tambah Jenis Kamar
        </a>


    </div>

    <div class="mb-8">

        <input
        type="text"
        wire:model.live="search"
        placeholder="Cari jenis kamar..."
        class="w-full rounded-2xl px-5 py-3 shadow
        bg-white/60 focus:bg-[#7FD6DA]/10
        outline-none transition"/>

    </div>

    <div class="space-y-5">
        @foreach ($kamars as $kamar)

        <div class="flex justify-between bg-white p-6 rounded-2xl shadow-lg hover:shadow-lg transition duration-300 border border-slate-200">

            <div>

                <div x-data="{ open: false, img: '' }">

                    <div class="flex gap-3 mb-4 overflow-x-auto">
                        @foreach ($kamar->gambars as $gambar)
                            <img
                                src="{{ asset('storage/' . $gambar->gambar) }}"
                                class="w-40 h-32 object-cover rounded-2xl shrink-0 cursor-pointer hover:opacity-80 transition"
                                @click="open = true; img = '{{ asset('storage/' . $gambar->gambar) }}'"
                            >
                        @endforeach
                    </div>

                    <template x-teleport="body">
                        <div
                            x-show="open"
                            x-transition
                            class="fixed inset-0 bg-black/80 flex items-center justify-center z-[999999]"
                        >
                            <!-- tombol X -->
                            <button
                                class="absolute top-5 right-5 text-white text-3xl font-bold"
                                @click="open = false"
                            >
                                &times;
                            </button>

                            <!-- gambar -->
                            <img
                                :src="img"
                                class="max-w-[90%] max-h-[90%] rounded-xl shadow-lg"
                            >
                        </div>
                    </template>

                </div>
                <h2 class="text-xl font-semibold">
                    Lantai {{ $kamar->lantai }}
                </h2>

                <p class="text-slate-500">
                    {{ $kamar->nama_kamar }}
                </p>

                <p class="text-sm text-slate-500">
                    {{ $kamar->deskripsi }}
                </p>

                <p class="text-violet-600 font-bold mt-2">
                    Rp {{ number_format($kamar->harga) }}
                </p>

            </div>

            <div x-data="{ open: false }" class="relative">

                <!-- tombol 3 titik -->
                <button
                    @click="open = !open"
                    class="text-slate-600 hover:text-slate-900 text-xl px-2">

                    ⋯
                </button>

                <!-- dropdown menu -->
                <div
                    x-show="open"
                    @click.away="open = false"
                    x-transition
                    class="absolute right-0 mt-2 w-36 bg-white border border-slate-200 rounded-xl shadow-lg z-50">

                    <!-- Edit -->
                    <a
                        href="/admin/edit_informasi_kamar/{{ $kamar->id }}"
                        class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100 rounded-t-xl">

                        Edit Data
                    </a>

                    <!-- Delete -->
                    <button
                        wire:click="delete({{ $kamar->id }})"
                        wire:confirm="Apakah anda yakin ingin menghapus data ini?"
                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-b-xl">

                        Hapus Data
                    </button>

                </div>
            </div>

        </div>

        @endforeach

        <div class="mt-6">
            {{ $kamars->links() }}
        </div>

    </div>
</div>
