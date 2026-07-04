<?php

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Penghuni;
use App\Models\Pembayaran;
use App\Models\Pengumuman;

new #[Layout('layouts.customer')] class extends Component {

    public function render()
    {
        $penghuni = Penghuni::with('kamar')
            ->where('user_id', auth()->id())
            ->first();

        $punyaKamar = $penghuni ? true : false;

        $pembayaran = Pembayaran::where('user_id', auth()->id())
            ->where('bulan', now()->format('F'))
            ->where('tahun', now()->year)
            ->first();

        $terakhir = Pembayaran::where('user_id', auth()->id())
            ->latest()
            ->first();

        $pengumumans = Pengumuman::latest()->take(5)->get();

        return view('livewire.pages.post.customer.dashboard_customer', [
            'punyaKamar' => $punyaKamar,

            'nomorKamar' => $penghuni?->kamar?->nomor_kamar,
            'statusPenghuni' => $penghuni?->status ?? '-',

            'tanggalMasuk' => $penghuni?->tanggal_masuk
                ? \Carbon\Carbon::parse($penghuni->tanggal_masuk)->format('d M Y')
                : '-',

            'tagihan' => $pembayaran?->nominal ?? 0,
            'statusTagihan' => $pembayaran?->status ?? 'belum_bayar',

            'bulanTerakhir' => $terakhir
                ? $terakhir->bulan . ' ' . $terakhir->tahun
                : '-',

            'nominalTerakhir' => $terakhir?->nominal ?? 0,
            'statusTerakhir' => $terakhir?->status ?? '-',

            'pengumumans' => $pengumumans,
        ]);
    }
};

?>

<div class="min-h-screen bg-[white] p-20">
    @if(!$punyaKamar)
        <div class="mb-8">
            <h1 class="text-3xl font-black text-slate-800">
                Halo, {{ auth()->user()->name }} 👋
            </h1>

            <p class="text-slate-500 mt-2">
                Selamat datang di di-kos.
            </p>
        </div>

        <div class="min-h-screenbg-[#F7FAFF]">
            
            <div class="bg-white p-10 rounded-2xl shadow-lg text-center border border-slate-200">
                
                <h1 class="text-2xl font-bold text-slate-700 mb-2">
                    Kamu belum memesan kamar
                </h1>

                <p class="text-slate-500 mb-5">
                    Silakan pesan kamar terlebih dahulu untuk melihat dashboard
                </p>

                <a href="{{ route('customer.kamar') }}"
                class="bg-[#F58A8A] text-white px-5 py-2 rounded-xl font-semibold
                        inline-block
                        transform transition-transform duration-200
                        hover:scale-110">
                    Pesan Kamar
                </a>

            </div>
        </div>

    @else
        <div class="mb-8">
            <h1 class="text-3xl font-black text-slate-800">
                Halo, {{ auth()->user()->name }} 👋
            </h1>

            <p class="text-slate-500 mt-2">
                Selamat datang di di-kos.
            </p>
        </div>

        <!-- CARD UTAMA -->
        <div class="grid md:grid-cols-2 gap-3 mb-4">

            <!-- KAMAR -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-lg ">

                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-bold text-slate-700">
                        Kamar Saya
                    </h2>

                    <div class="w-12 h-12 rounded-2xl bg-cyan-100 flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            class="w-6 h-6 text-cyan-600">

                            <!-- bed frame -->
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 12V7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v5" />

                            <!-- mattress -->
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 12h18v5H3v-5z" />

                            <!-- legs -->
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M5 17v2m14-2v2" />

                            <!-- pillow line -->
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M7 9h4" />

                        </svg>

                    </div>
                </div>

                <h3 class="text-3xl font-black text-slate-800">
                    {{ $nomorKamar ?? '-' }}
                </h3>

                <div class="mt-4 space-y-1 text-sm">
                    <p class="text-slate-500">
                        Status :
                        <span class="font-semibold text-green-600">
                            {{ ucfirst($statusPenghuni) }}
                        </span>
                    </p>

                    <p class="text-slate-500">
                        Masuk sejak {{ $tanggalMasuk }}
                    </p>
                </div>

            </div>

            <!-- TAGIHAN -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-lg">

                <div class="flex items-center justify-between mb-4">

                    <h2 class="font-bold text-slate-700">
                        Tagihan Bulan Ini
                    </h2>

                    <div class="w-12 h-12 rounded-2xl bg-violet-100 flex items-center justify-center">

                        <svg
                            class="w-6 h-6 text-violet-600"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2.2">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>

                        </svg>

                    </div>

                </div>

                <h3 class="text-3xl font-black text-violet-600">
                    Rp {{ number_format($tagihan ?? 0) }}
                </h3>

                <div class="mt-4">
                    @if($statusTagihan == 'lunas')
                        <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-sm font-semibold">
                            Lunas
                        </span>
                    @else
                        <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm font-semibold">
                            Belum Bayar
                        </span>
                    @endif
                </div>

            </div>

        </div>

        <!-- PEMBAYARAN TERAKHIR -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-lg mb-4">

            <h2 class="font-bold text-slate-800 mb-4">
                Pembayaran Terakhir
            </h2>

            <div class="flex justify-between items-center">

                <div>
                    <p class="font-semibold text-slate-700">
                        {{ $bulanTerakhir ?? '-' }}
                    </p>

                    <p class="text-slate-500 text-sm">
                        Rp {{ number_format($nominalTerakhir ?? 0) }}
                    </p>
                </div>

                <span class="
                    px-4 py-2 rounded-full text-sm font-semibold
                    {{ $statusTerakhir == 'lunas'
                        ? 'bg-green-100 text-green-600'
                        : 'bg-red-100 text-red-600' }}
                ">
                    {{ ucfirst($statusTerakhir) }}
                </span>

            </div>

        </div>

        <!-- QUICK ACTION -->
        <div class="grid md:grid-cols-2 gap-3 mb-4">

        <!-- PENGADUAN -->
        <a href="{{ route('customer.pengaduan') }}"
            class="bg-white rounded-2xl p-6 border border-slate-200 shadow-lg ">

            <div class="w-12 h-12 rounded-xl bg-[#7FD6DA]/20 flex items-center justify-center mb-3">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/>
                </svg>
            </div>

            <div class="font-semibold text-slate-800 group-hover:text-slate-900">
                Pengaduan
            </div>

            <p class="text-xs text-slate-500 mt-1">
                Kirim & lihat status pengaduan
            </p>

        </a>

        <!-- PENGUMUMAN -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-lg ">

            <div class="flex items-center justify-between mb-4">
                <h2 class="font-bold text-slate-800">
                    Pengumuman
                </h2>

            </div>

        <div class="space-y-3">

                @forelse ($pengumumans as $pengumuman)
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">

                        <div class="flex justify-between items-start gap-2">

                            <h3 class="font-semibold text-slate-800 text-sm">
                                {{ $pengumuman->judul }}
                            </h3>

                            <span class="text-[10px] text-slate-400 whitespace-nowrap">
                                {{ $pengumuman->created_at->format('d M Y') }}
                            </span>

                        </div>

                        <p class="text-xs text-slate-600 mt-1">
                            {{ $pengumuman->isi }}
                        </p>

                    </div>
                @empty
                    <p class="text-sm font-medium text-slate-600">
                        Tidak ada pengumuman terbaru.
                    </p>
                @endforelse

            </div>

        </div>

    </div>
        
    @endif
</div>