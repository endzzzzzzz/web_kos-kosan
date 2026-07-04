<?php

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\InformasiKamar;
use App\Models\Penghuni;

new #[Layout('layouts.customer')] class extends Component
{
    public function render()
    {
        $dataPenghuni = Penghuni::with(['kamar.informasiKamar'])
            ->where('user_id', auth()->id())
            ->where('status', 'aktif')
            ->first();

        return view('livewire.pages.post.customer.kamar', [
            'kamars' => InformasiKamar::with(['gambars', 'kamars'])->get(),
            'dataPenghuni' => $dataPenghuni
        ]);
    }

    public function keluarKamar()
    {
        $penghuni = Penghuni::where('user_id', auth()->id())
            ->where('status', 'aktif')
            ->first();

        if (!$penghuni) return;

        $penghuni->update(['status' => 'dibatalkan']);
        $penghuni->kamar->update(['status' => 'kosong']);
    }
};
?>

<div class="min-h-screen bg-[white] p-20">
    
    @if($dataPenghuni)

    <!-- Header Judul -->
    <h1 class="text-3xl font-black mb-8">
        Kamar Saya
    </h1>

        <div class="bg-white rounded-2xl p-8 shadow-lg flex items-center justify-between border border-slate-200">
            <div>
                <h3 class="text-xl font-bold text-[#C97B63]">Status Penghuni Aktif</h3>
                <p class="text-slate-600 mt-1">Anda saat ini tinggal di 
                    <span class="font-black text-[#8B6DFF]">{{ $dataPenghuni->kamar->informasiKamar->nama_kamar ?? '-' }}</span>, 
                    lantai <span class="font-black text-[#8B6DFF]">{{ $dataPenghuni->kamar->informasiKamar->lantai ?? '-' }}</span>,  
                    - Nomor <span class="font-black text-[#8B6DFF]">{{ $dataPenghuni->kamar->nomor_kamar ?? '-' }}</span>
                </p>
            </div>
            <div class="flex items-center gap-4">
                <div class="bg-[#DDFBFF] text-[#54D8E3] px-6 py-2 rounded-full font-black text-sm uppercase tracking-wider">
                    Menghuni
                </div>
                <button 
                    wire:click="keluarKamar"
                    wire:confirm="Yakin ingin keluar dari kamar?"
                    class="bg-red-100 text-red-500 px-6 py-2 rounded-full text-sm uppercase font-black tracking-wider hover:bg-red-500 hover:text-white transition">
                    Keluar
                </button>
            </div>
        </div>
    @else

        <!-- Filter & Pencarian -->
        <h1 class="text-3xl font-black mb-8">Daftar Kamar</h1>

        <div class="mb-6 flex flex-wrap gap-3">
            <input type="text" id="searchInput" placeholder="Cari nama kamar..." 
                oninput="filterKamar()" 
                class="rounded-2xl px-6 py-3 text-sm bg-white shadow-sm focus:ring-2 focus:ring-[#F58A8A] w-64 border-0 outline-none">

            <button onclick="setFilter('semua', this)" 
                class="filter-btn px-6 py-3 rounded-full text-sm font-bold bg-[#F58A8A] text-white shadow-sm transition">
                Semua
            </button>

            @foreach(App\Models\InformasiKamar::select('lantai')->distinct()->orderBy('lantai')->pluck('lantai') as $lt)
                <button onclick="setFilter('{{ $lt }}', this)" 
                    class="filter-btn px-6 py-3 rounded-full text-sm font-bold bg-white text-[#F58A8A] shadow-sm hover:bg-[#F58A8A] hover:text-white transition">
                    Lantai {{ $lt }}
                </button>
            @endforeach
        </div>

        <!-- Grid Kamar -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="kamarGrid">
            @foreach ($kamars as $kamarItem)
                <div class="kamar-card bg-white rounded-2xl overflow-hidden shadow-lg border border-slate-200 hover:shadow-2xl transition-all duration-300"
                    data-nama="{{ strtolower($kamarItem->nama_kamar) }}"
                    data-lantai="{{ $kamarItem->lantai }}">   
                    
                    <div class="swiper kamar-swiper w-full h-52">
                        <div class="swiper-wrapper">
                            @foreach ($kamarItem->gambars as $gambar)
                                <div class="swiper-slide">
                                    <img src="{{ asset('storage/' . $gambar->gambar) }}" class="w-full h-52 object-cover">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="p-6">
                        <h3 class="text-xl font-black text-slate-800 mb-2">{{ $kamarItem->nama_kamar }}</h3>
                        <p class="text-slate-500 text-sm mb-4 line-clamp-2">{{ $kamarItem->deskripsi }}</p>
                        <div class="flex items-center justify-between border-t border-slate-100 pt-4">
                            <p class="text-2xl font-black text-[#54D8E3]">Rp {{ number_format($kamarItem->harga, 0, ',', '.') }}</p>
                            <a href="{{ route('customer.pengajuan', $kamarItem->id) }}" 
                                class="bg-[#F58A8A] text-white text-sm font-bold px-6 py-3 rounded-2xl hover:scale-105 transition">
                                Pesan
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
    @endif
</div>

<script>
    const searchInput = document.getElementById('searchInput');
    let activeFilter = 'semua';

    function setFilter(val, el) {
        activeFilter = val;

        document.querySelectorAll('.filter-btn').forEach(b => {
            b.classList.remove('bg-[#F58A8A]', 'text-white');
            b.classList.add('bg-white', 'text-[#F58A8A]');
        });

        el.classList.remove('bg-white', 'text-[#F58A8A]');
        el.classList.add('bg-[#F58A8A]', 'text-white');

        filterKamar();
    }

    function filterKamar() {
        const q = searchInput ? searchInput.value.toLowerCase() : '';
        document.querySelectorAll('.kamar-card').forEach(card => {
            const matchSearch = card.dataset.nama.includes(q);
            
            const matchFilter = activeFilter === 'semua' || card.dataset.lantai === activeFilter;
            card.style.display = (matchSearch && matchFilter) ? '' : 'none';
        });
    }

    filterKamar();

    document.querySelectorAll('.kamar-swiper').forEach(function(el) {
        new Swiper(el, { slidesPerView: 1, loop: true, speed: 800, autoplay: { delay: 3000, disableOnInteraction: false } });
    });
</script>