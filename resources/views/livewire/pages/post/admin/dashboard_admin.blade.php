<?php

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\Pembayaran;
use Carbon\Carbon;
use App\Models\InformasiKamar;

new #[Layout('layouts.admin')] class extends Component
{
    public function render()
    {
        $totalKamar = Kamar::count();

        $kamarTerisi = Kamar::where(
            'status',
            'terisi'
        )->count();

        $kamarKosong = Kamar::where(
            'status',
            'kosong'
        )->count();

        $penghuniAktif = Penghuni::where(
            'status',
            'aktif'
        )->count();

        $belumBayar = Pembayaran::where(
            'status',
            'belum_bayar'
        )->count();

        $pendapatanBulanIni = Pembayaran::where(
            'status',
            'lunas'
        )
        ->where('bulan', now()->format('F'))
        ->where('tahun', now()->format('Y'))
        ->sum('nominal');

        $pembayaranTerbaru = Pembayaran::with(['pengajuan.user', 'pengajuan.kamar'])
            ->latest()
            ->take(5)
            ->get();

        $tunggakan = Pembayaran::with(['pengajuan.user', 'pengajuan.kamar'])
            ->where('status', 'belum_bayar')
            ->latest()
            ->take(5)
            ->get();

        
        $jenisKamars = InformasiKamar::withCount([
            'kamars as total_kamar',
            'kamars as kamar_terisi' => function ($query) {
                $query->where('status', 'terisi');
            }
        ])->get();
        

        return view('livewire.pages.post.admin.dashboard_admin', [

            'totalKamar' => $totalKamar,
            'kamarTerisi' => $kamarTerisi,
            'kamarKosong' => $kamarKosong,
            'penghuniAktif' => $penghuniAktif,
            'belumBayar' => $belumBayar,
            'pendapatanBulanIni' => $pendapatanBulanIni,

            'pembayaranTerbaru' => $pembayaranTerbaru,
            'tunggakan' => $tunggakan,
            'jenisKamars' => $jenisKamars,
        ]);
    }
};

?>

<div class="space-y-4 p-6">

    <!-- HEADER -->
    <div class="flex items-center justify-between">

        <div>

            <h1 class="text-2xl font-bold text-slate-800">
                Dashboard
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Selamat datang kembali 👋
            </p>

        </div>
    </div>

    <!-- STATS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

        <!-- TOTAL -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-lg">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-slate-500">
                        Total Kamar
                    </p>

                    <h2 class="text-2xl font-bold text-slate-800 mt-2">
                        {{ $totalKamar }}
                    </h2>

                </div>

                <div class="w-12 h-12 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-xl">

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

        </div>

        <!-- TERISI -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-lg">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-slate-500">
                        Kamar Terisi
                    </p>

                    <h2 class="text-2xl font-bold text-emerald-600 mt-2">
                        {{ $kamarTerisi }}
                    </h2>

                </div>

                <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl">

                    ✔

                </div>

            </div>

        </div>

        <!-- KOSONG -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-lg">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-slate-500">
                        Kamar Kosong
                    </p>

                    <h2 class="text-2xl font-bold text-orange-500 mt-2">
                        {{ $kamarKosong }}
                    </h2>

                </div>

                <div class="w-12 h-12 rounded-2xl bg-orange-100 text-orange-500 flex items-center justify-center text-xl">

                    ◌

                </div>

            </div>

        </div>

        <!-- BELUM BAYAR -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-lg">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-slate-500">
                        Belum Bayar
                    </p>

                    <h2 class="text-2xl font-bold text-red-500 mt-2">
                        {{ $belumBayar }}
                    </h2>

                </div>

                <div class="w-12 h-12 rounded-2xl bg-red-100 text-red-500 flex items-center justify-center text-xl">

                    ⚠

                </div>

            </div>

        </div>

    </div>

   <!-- SECOND -->
    <div class="grid grid-cols-1 xl:grid-cols-4 gap-4">

        <!-- OCCUPANCY -->
        <div class="xl:col-span-3 bg-white border border-slate-200 rounded-2xl p-5 shadow-lg">

            <div class="flex items-start justify-between mb-6">

                <div>

                    <h2 class="font-bold text-slate-800 text-lg">
                        Hunian Kos
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Status kamar keseluruhan
                    </p>

                </div>

                <div class="text-right">

                    <p class="text-2xl font-bold text-indigo-600">
                        {{ round(($kamarTerisi / max($totalKamar, 1)) * 100) }}%
                    </p>

                    <p class="text-xs text-slate-400">
                        Occupancy
                    </p>

                </div>

            </div>

            <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden">

                <div
                    class="h-full rounded-full bg-gradient-to-r from-orange-400 to-amber-500"
                    style="width: {{ ($kamarTerisi / max($totalKamar, 1)) * 100 }}%">
                </div>

            </div>

            <div class="flex justify-between mt-3 text-sm text-slate-500">

                <span>
                    {{ $kamarTerisi }} kamar terisi
                </span>

                <span>
                    {{ $kamarKosong }} kamar kosong
                </span>

            </div>

            <!-- JENIS KAMAR -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-5">

                @foreach ($jenisKamars as $jenis)

                    <div class="border border-slate-100 rounded-2xl p-4 bg-slate-50/70">

                        <div class="flex items-center justify-between mb-3">

                            <div>

                                <h3 class="font-semibold text-slate-700">
                                    {{ $jenis->nama_kamar }}
                                </h3>

                                <p class="text-xs text-slate-400">
                                    Lantai {{ $jenis->lantai }}
                                </p>

                            </div>

                            <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600 text-lg">

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

                        <div class="space-y-2 text-sm">

                            <div class="flex justify-between">

                                <span class="text-slate-500">
                                    Total
                                </span>

                                <span class="font-semibold text-slate-700">
                                    {{ $jenis->total_kamar }}
                                </span>

                            </div>

                            <div class="flex justify-between">

                                <span class="text-slate-500">
                                    Terisi
                                </span>

                                <span class="font-semibold text-emerald-600">
                                    {{ $jenis->kamar_terisi }}
                                </span>

                            </div>

                            <div class="flex justify-between">

                                <span class="text-slate-500">
                                    Kosong
                                </span>

                                <span class="font-semibold text-orange-500">
                                    {{ $jenis->total_kamar - $jenis->kamar_terisi }}
                                </span>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

        <!-- SIDE -->
        <div class="space-y-6">

            <!-- KALENDER -->
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-lg">

                <div class="flex items-center justify-between mb-4">

                    <div>

                        <h2 class="font-bold text-slate-800">
                            Kalender
                        </h2>

                        <p class="text-xs text-slate-400 mt-1">
                            {{ now()->format('F Y') }}
                        </p>

                    </div>

                    <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600">

                        📅

                    </div>

                </div>

                <div class="grid grid-cols-7 gap-2 text-center text-xs">

                    @foreach (['S','S','R','K','J','S','M'] as $hari)

                        <div class="font-semibold text-slate-400 py-1">
                            {{ $hari }}
                        </div>

                    @endforeach

                    @for ($i = 1; $i <= 31; $i++)

                        <div class="
                            h-7 rounded-lg flex items-center justify-center
                            {{ now()->day == $i
                                ? 'bg-indigo-600 text-white font-bold'
                                : 'text-slate-500 hover:bg-slate-100'
                            }}
                        ">

                            {{ $i }}

                        </div>

                    @endfor

                </div>

            </div>

            <!-- PEMASUKAN -->
            <div class="bg-gradient-to-br from-orange-400 to-amber-600 rounded-2xl p-5 text-white shadow-lg">

                <p class="text-sm text-white/70">
                    Pendapatan Bulan Ini
                </p>

                <h2 class="text-2xl font-bold mt-3">
                    Rp {{ number_format($pendapatanBulanIni) }}
                </h2>

                <p class="text-sm text-white/70 mt-4">
                    Dari pembayaran penghuni aktif
                </p>

            </div>

        </div>

    </div>

    <!-- THIRD -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">

        <!-- PEMBAYARAN -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-lg">

            <div class="flex items-center justify-between mb-5">

                <div>

                    <h2 class="font-bold text-slate-800">
                        Pembayaran Terbaru
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Aktivitas pembayaran terakhir
                    </p>

                </div>

            </div>

            <div class="space-y-3">

                @foreach ($pembayaranTerbaru as $item)

                    <div class="flex items-center justify-between border border-slate-100 rounded-xl px-3 py-2.5">

                        <div>

                            <p class="text-sm font-semibold text-slate-700">
                                {{ $item->pengajuan->user->name ?? '-' }}
                            </p>

                            <p class="text-xs text-slate-400 mt-1">
                                Kamar {{ $item->pengajuan->kamar->nomor_kamar ?? '-' }}
                                •
                                {{ $item->bulan }}
                            </p>

                        </div>

                        @if ($item->status == 'lunas')

                            <span class="text-xs px-3 py-1 rounded-lg bg-emerald-100 text-emerald-600 font-semibold">
                                Lunas
                            </span>

                        @else

                            <span class="text-xs px-3 py-1 rounded-lg bg-red-100 text-red-500 font-semibold">
                                Belum
                            </span>

                        @endif

                    </div>

                @endforeach

            </div>

        </div>

        <!-- TUNGGAKAN -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-lg">

            <div class="flex items-center justify-between mb-5">

                <div>

                    <h2 class="font-bold text-slate-800">
                        Penghuni Menunggak
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Belum melakukan pembayaran
                    </p>

                </div>

                <div class="w-10 h-10 rounded-xl bg-red-100 text-red-500 flex items-center justify-center">

                    ⚠

                </div>

            </div>

            <div class="space-y-3">

                @forelse ($tunggakan as $item)

                    <div class="flex items-center justify-between border border-red-100 bg-red-50/50 rounded-xl px-3 py-2.5">

                        <div>

                            <p class="text-sm font-semibold text-slate-700">
                                {{ $item->pengajuan->user->name ?? '-' }}
                            </p>

                            <p class="text-xs text-slate-400 mt-1">
                                {{ $item->bulan }} {{ $item->tahun }}
                            </p>

                        </div>

                        <span class="text-xs px-3 py-1 rounded-lg bg-red-100 text-red-500 font-semibold">
                            Belum Bayar
                        </span>

                    </div>

                @empty

                    <div class="text-center py-10">

                        <p class="text-sm text-slate-400">
                            Tidak ada tunggakan 🎉
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>