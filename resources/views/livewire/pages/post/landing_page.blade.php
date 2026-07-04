<?php

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\InformasiKamar;

new #[Layout('layouts.landing')] class extends Component
{
    public function render()
    {
        return view('livewire.pages.post.landing_page', [
            'kamars' => InformasiKamar::with('gambars')->get(),
        ]);
    }
};

?>

<div class="bg-white text-slate-800" style="overflow-x: clip;">
    <style>
        @keyframes slideInLeft {
            0% { transform: translateX(-100%); opacity: 0; }
            100% { transform: translateX(0); opacity: 0,9; }
        }
        
        .animate-slide-in-left {
            animation: slideInLeft 1.2s ease-out forwards;
        }

        @keyframes slideInLeftFade {
            0% {
                opacity: 0;
                transform: translateX(-30px); /* Mulai dari 30px di sebelah kiri */
            }
            100% {
                opacity: 1;
                transform: translateX(0);    /* Berhenti di posisi aslinya */
            }
        }

        .animate-fade-in-up {
            /* Menggunakan nama keyframe yang baru, durasi 1.5s, dan ease-out */
            animation: slideInLeftFade 1.8s ease-out forwards;
        }

        .nav-link.active {
            color: #F28C28;
            position: relative;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -8px;
            width: 100%;
            height: 3px;
            background: #F28C28;
            border-radius: 999px;
        }
        
    </style>

    <!-- NAVBAR -->
    <div class="fixed top-0 left-0 z-50 w-full">

        <!-- TOP BAR -->
        <div id="top-bar" class="bg-[#A9DBDC] transition-all duration-300 pl-9">
            <div class="flex h-10 items-center justify-between px-7 text-slate-600">
                <!-- Bagian Kontak (Kiri) -->
                <div class="flex items-center gap-4">
                    <!-- Email -->
                    <a href="https://mail.google.com/mail/?view=cm&fs=1&to=endiazalalkawi@gmail.com" class="flex text-xs items-center gap-1 hover:text-[#63C6CB] transition-colors text-[#F9F9F9]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#F9F9F9]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>endiazalalkawi@gmail.com</span>
                    </a>

                    <span class="text-[#F9F9F9]/50">|</span>

                    <!-- WhatsApp -->
                    <a href="https://wa.me/6282179622877" target="_blank" class="flex items-center text-xs gap-1 hover:text-[#63C6CB] transition-colors text-[#F9F9F9]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-[#F9F9F9]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        <span>082179622877</span>
                    </a>
                </div>
                
            </div>
        </div>

        <!-- HEADER -->
        <header id="main-header" class="w-full border-b border-slate-200 bg-white backdrop-blur-xl transition-all duration-300">
            <nav id="navbar" class="flex items-center justify-between px-16 py-3 transition-all duration-300">

                <!-- LOGO -->
                <div class="flex items-center flex-1 h-auto w-10">
                    <img src="{{ asset('images/logo.svg') }}" alt="di-kos logo" class="h-14 w-40">
                </div>

                <!-- MENU -->
                <div class="hidden gap-10 text-sm font-semibold text-slate-700 lg:flex flex-1 justify-center">
                    <a href="#home" class="nav-link transition hover:text-[#F28C28]">Home</a>
                    <a href="#fasilitas" class="nav-link transition hover:text-[#F28C28]">Fasilitas</a>
                    <a href="#tipe-kamar" class="nav-link transition hover:text-[#F28C28]">Tipe Kamar</a>
                    <a href="#syarat" class="nav-link transition hover:text-[#F28C28]">Syarat & Peraturan</a>
                </div>

                <!-- BUTTON -->
                <div class="flex-1 flex justify-end">
                    <a href="/login"
                    class="rounded-xl bg-[#F58A8A] px-6 py-3 text-sm font-bold text-white transition hover:scale-105 inline-block">
                        Login / Daftar
                    </a>
                </div>
            </nav>
        </header>

    </div>

    <!-- HOME -->
    <section id="home" class="relative pt-[104px] overflow-hidden h-screen bg-[#F7FAFF]">

        <!-- background -->
        <div class="absolute inset-0 overflow-hidden">

            <div class="absolute inset-0 h-full w-full">

                <img
                    src="{{ asset('images/gedung (2).png') }}"
                    class="h-full w-full object-cover"
                    alt="Gedung Kos"
                >

                <div class="absolute inset-0 bg-black/10"></div>

            </div>

            <div
                class="absolute left-0 top-0 h-full w-[72%] bg-white opacity-95  animate-slide-in-left"
                style="clip-path: polygon(0 0, 68% 0, 100% 100%, 0% 100%);">
            </div>

        </div>

        <!-- CONTENT -->
        <div class="relative z-10">   

            <!-- HERO -->
            <div class="flex min-h-[calc(100vh-90px)] items-center px-8 pb-8 lg:px-16 pt-14">

                <div class="max-w-4xl animate-fade-in-up">

                    <!-- BADGE -->
                    <div class="mb-8 inline-flex items-center gap-3 rounded-full bg-[#FFF4D9] px-7 py-3 text-sm font-semibold text-slate-700 shadow-sm">

                        ✦ Kos campur, dengan fasilitas lengkap

                    </div>

                    <!-- TITLE -->
                    <h1 class="text-2xl font-black leading-tight text-slate-800 md:text-5xl">
                        Tempat tinggal nyaman
                    </h1>
                    <h1 class="text-2xl font-black leading-tight text-slate-800 md:text-5xl">untuk</h1>
                    <h1 class="text-2xl font-black leading-tight text-slate-800 md:text-5xl">
                        <span class="text-[#8B6DFF]">
                            belajar,
                        </span>

                        <span class="text-[#F58A8A]">
                            berkembang,
                        </span>

                        
                    </h1>
                    <h1 class="text-2xl font-black leading-tight text-slate-800 md:text-5xl">
                        dan

                        <span class="text-[#6ED6DB]">
                            beristirahat.
                        </span>
                    </h1>

                    <!-- DESC -->
                    <p class="mt-5 max-w-2xl text-sm leading-relaxed text-slate-500 md:text-lg">

                        di-kos. menghadirkan pengalaman tinggal yang nyaman,
                        bersih, modern, dan aman untuk mahasiswa
                        maupun pekerja.

                    </p>

                    

                </div>

            </div>

        </div>
        
    </section>
    <script>

        const topBar = document.getElementById('top-bar');
        const navbar = document.getElementById('navbar');
        const header = document.getElementById('main-header');

        window.addEventListener('scroll', () => {

            if (window.scrollY > 30) {

                // TOP BAR HIDE
                topBar.style.marginTop = '-40px';

                // NAVBAR SHRINK
                navbar.classList.remove('py-3');
                navbar.classList.add('py-2');

                // SHADOW
                header.classList.add('shadow-md');

            } else {

                // TOP BAR SHOW
                topBar.style.marginTop = '0px';

                // NAVBAR NORMAL
                navbar.classList.remove('py-2');
                navbar.classList.add('py-3');

                // REMOVE SHADOW
                header.classList.remove('shadow-md');

            }

        });

    </script>

    <!-- FASILITAS -->
    <section id="fasilitas" class="scroll-mt-15 py-15 bg-[white]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between w-full mb-15">
                
                <img src="{{ asset('images/logo.svg') }}" 
                    alt="di-kos logo" 
                    class="h-25 w-auto">

                <div class="text-right">
                    <h4 class="text-5xl font-black text-slate-800 mb-5">
                        Fasilitas termasuk
                    </h4>

                    <p class="text-sm text-slate-400">
                        Tanpa biaya tambahan — sudah masuk dalam harga sewa
                    </p>
                </div>

            </div>

            <!-- Fasilitas small cards -->
            <div class="flex flex-wrap gap-2 justify-between mb-15">

                <!-- Listrik -->
                <div class="w-40 h-15 justify-center flex items-center gap-2 px-3 py-2  border border-slate-100 rounded-lg shadow-lg">
                    <div class="w-8 h-8 flex items-center justify-center bg-[#F7FAFF] rounded-full">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div class="leading-tight">
                        <p class="text-sm font-medium text-slate-600">Listrik</p>
                        <p class="text-[10px] text-slate-400">Termasuk</p>
                    </div>
                </div>

                <!-- WiFi -->
                <div class="w-40 h-15 justify-center flex items-center gap-2 px-3 py-2 bg-white border border-slate-100 rounded-lg shadow-lg">
                    <div class="w-8 h-8 flex items-center justify-center bg-[#FFF4D9] rounded-full">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.111 16.556a5 5 0 017.778 0M5.05 13.5a9 9 0 0113.9 0M1.99 9.444a13 13 0 0120.02 0M12 20h.01"/>
                        </svg>
                    </div>
                    <div class="leading-tight">
                        <p class="text-sm font-medium text-slate-600">WiFi</p>
                        <p class="text-[10px] text-slate-400">Termasuk</p>
                    </div>
                </div>

                <!-- Air -->
                <div class="w-40 h-15 justify-center flex items-center gap-2 px-3 py-2 bg-white border border-slate-100 rounded-lg shadow-lg">
                    <div class="w-8 h-8 flex items-center justify-center bg-[#DDFBFF] rounded-full">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3.5C12 3.5 6.5 10 6.5 14.2C6.5 17.4 8.98 20 12 20C15.02 20 17.5 17.4 17.5 14.2C17.5 10 12 3.5 12 3.5Z"/>
                        </svg>
                    </div>
                    <div class="leading-tight">
                        <p class="text-sm font-medium text-slate-600">Air</p>
                        <p class="text-[10px] text-slate-400">Termasuk</p>
                    </div>
                </div>

                <!-- Kamar mandi -->
                <div class="w-40 h-15 justify-center flex items-center gap-2 px-3 py-2 bg-white border border-slate-100 rounded-lg shadow-lg">
                    <div class="w-8 h-8 flex items-center justify-center bg-[#E6E8EF] rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="w-6 h-6 text-slate-500">

                            <!-- pipe -->
                            <path d="M6 4v6" />
                            <path d="M6 4h6" />

                            <!-- shower head -->
                            <path d="M12 6h6a2 2 0 0 1 2 2v2H12z" />

                            <!-- water drops -->
                            <path d="M14 13v2" />
                            <path d="M17 13v2" />
                            <path d="M20 13v2" />
                        </svg>
                    </div>
                    <div class="leading-tight">
                        <p class="text-sm font-medium text-slate-600">Kamar mandi</p>
                        <p class="text-[10px] text-slate-400">Dalam</p>
                    </div>
                </div>

                <!-- Laundry -->
                <div class="w-40 h-15 justify-center flex items-center gap-2 px-3 py-2 bg-white border border-slate-100 rounded-lg shadow-lg">
                    <div class="w-8 h-8 flex items-center justify-center bg-[#F7FAFF] rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="w-6 h-6 text-slate-500">

                            <!-- body -->
                            <rect x="5" y="3" width="14" height="18" rx="2"/>

                            <!-- control panel -->
                            <circle cx="8" cy="7" r="1"/>
                            <circle cx="12" cy="7" r="1"/>

                            <!-- drum -->
                            <circle cx="12" cy="14" r="4"/>

                            <!-- small water line -->
                            <path d="M9 14h6"/>
                        </svg>
                    </div>
                    <div class="leading-tight">
                        <p class="text-sm font-medium text-slate-600">Laundry</p>
                        <p class="text-[10px] text-slate-400">Bersama</p>
                    </div>
                </div>

                <!-- Dapur -->
                <div class="w-40 h-15 justify-center flex items-center gap-2 px-3 py-2 bg-white border border-slate-100 rounded-lg shadow-lg">
                    <div class="w-8 h-8 flex items-center justify-center bg-[#FFF4D9] rounded-full">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 4h12v4H6zM4 8v10a2 2 0 002 2h12a2 2 0 002-2V8"/>
                        </svg>
                    </div>
                    <div class="leading-tight">
                        <p class="text-sm font-medium text-slate-600">Dapur</p>
                        <p class="text-[10px] text-slate-400">Bersama</p>
                    </div>
                </div>

                <!-- Parkiran -->
                <div class="w-40 h-15 flex items-center gap-2 px-3 py-2 bg-white border border-slate-100 rounded-lg shadow-lg justify-center">
                    <div class="w-8 h-8 flex items-center justify-center bg-[#DDFBFF] rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="w-6 h-6 text-slate-500">

                            <!-- circle -->
                            <circle cx="12" cy="12" r="9"/>

                            <!-- letter P -->
                            <path d="M10 16V8h3a2 2 0 0 1 0 4h-3"/>
                        </svg>
                    </div>
                    <div class="leading-tight">
                        <p class="text-sm font-medium text-slate-600">Parkiran</p>
                        <p class="text-[10px] text-slate-400">Tersedia</p>
                    </div>
                </div>

            </div>

            <div class="grid gap-1.5 mb-10 overflow-hidden"
                style="grid-template-columns: 2fr 1fr 1fr 1fr; grid-template-rows: repeat(2, 220px);">

                <!-- FOTO BESAR KIRI -->
                <div style="grid-row: 1 / 3;" class="overflow-hidden">
                    <a href="{{ asset('images/gedung (2).png') }}"
                        class="glightbox block h-full"
                        data-gallery="galeri-kos">
                        <img src="{{ asset('images/gedung (2).png') }}"
                            class="w-full h-full object-cover hover:scale-105 transition duration-500 rounded-xl">
                    </a>
                </div>

                <!-- BARIS 1 -->
                <div class="overflow-hidden">
                    <a href="{{ asset('images/kamar lt1.png') }}"
                        class="glightbox block h-full"
                        data-gallery="galeri-kos">
                        <img src="{{ asset('images/kamar lt1.png') }}" class="w-full h-full object-cover rounded-xl hover:scale-105 transition duration-500">
                    </a>
                </div>

                <div class="overflow-hidden">
                    <a href="{{ asset('images/kamar lt2.png') }}"
                        class="glightbox block h-full"
                        data-gallery="galeri-kos">
                        <img src="{{ asset('images/kamar lt2.png') }}" class="w-full h-full object-cover rounded-xl hover:scale-105 transition duration-500">
                    </a>
                </div>

                <div class="overflow-hidden">
                    <a href="{{ asset('images/lorong.png') }}"
                            class="glightbox block h-full"
                            data-gallery="galeri-kos">
                        <img src="{{ asset('images/lorong.png') }}" class="w-full h-full object-cover rounded-xl hover:scale-105 transition duration-500">
                    </a>
                </div>

                <!-- BARIS 2 -->
                <div class="overflow-hidden">
                    <a href="{{ asset('images/laundry bersama.png') }}"
                        class="glightbox block h-full"
                        data-gallery="galeri-kos">
                        <img src="{{ asset('images/laundry bersama.png') }}" class="w-full h-full object-cover rounded-xl hover:scale-105 transition duration-500">
                    </a>
                </div>

                <div class="overflow-hidden">
                   <a href="{{ asset('images/kamar lt3.png') }}"
                        class="glightbox block h-full"
                        data-gallery="galeri-kos">
                        <img src="{{ asset('images/kamar lt3.png') }}" class="w-full h-full object-cover rounded-xl hover:scale-105 transition duration-500">
                    </a>
                </div>

                <div class="overflow-hidden">
                   <a href="{{ asset('images/dapur bersama.png') }}"
                    class="glightbox block h-full"
                    data-gallery="galeri-kos">
                        <img src="{{ asset('images/dapur bersama.png') }}" class="w-full h-full object-cover rounded-xl hover:scale-105 transition duration-500">
                    </a>
                </div>

            </div>
            
        </div>
    </section>
    <script>
        GLightbox({
            selector: '.glightbox',
            touchNavigation: true,
            loop: true
        });
    </script>

    <!-- LOKASi -->
    <section id="lokasi" class="scroll-mt-15 py-12 bg-[#F7FAFF]">
        <div class="max-w-7xl mx-auto px-6">

            <!-- HEADER -->
            <div class="text-center mb-10">
                <h2 class="text-4xl font-black text-slate-800">Lokasi Strategis</h2>
                <p class="text-slate-500 mt-2">
                    Dekat Universitas Negeri Padang (UNP)
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-10 items-center">

                <!-- INFO -->
                <div class="space-y-5">

                    <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
                        <h3 class="text-lg font-bold text-slate-800 mb-2">
                            📍 Area Kos
                        </h3>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            Sekitar Universitas Negeri Padang (UNP),  
                            Kota Padang, Sumatera Barat
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">

                        <div class="bg-[#DDFBFF] rounded-xl p-4">
                            <p class="text-sm font-bold text-slate-700">± 5 menit</p>
                            <p class="text-xs text-slate-500">ke kampus UNP</p>
                        </div>

                        <div class="bg-[#FFF4D9] rounded-xl p-4">
                            <p class="text-sm font-bold text-slate-700">Akses mudah</p>
                            <p class="text-xs text-slate-500">transport umum</p>
                        </div>

                    </div>

                    <div class="text-xs text-slate-500 leading-relaxed">
                        ✔ Lingkungan mahasiswa  
                        ✔ Dekat warung & fasilitas umum  
                        ✔ Aman & nyaman untuk tinggal
                    </div>

                </div>

                <!-- MAP -->
                <div class="rounded-2xl overflow-hidden shadow-sm border border-slate-100">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1895.970389138864!2d100.34815934003936!3d-0.8969136986320179!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd4b8accb64ea31%3A0x9e6d3a9be19372d1!2sUniversitas%20Negeri%20Padang!5e1!3m2!1sid!2sid!4v1781296314885!5m2!1sid!2sid"
                        class="w-full h-[350px]"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

            </div>
        </div>
    </section>

    <!-- TIPE KAMAR -->
    <section id="tipe-kamar" class="scroll-mt-16 py-13 bg-[white]">
        <div class="max-w-7xl mx-auto px-6">

            <div class="text-left mb-12">
                <h2 class="text-5xl font-black text-[#C97B63]">Tipe Kamar</h2>
                <p class="text-[#D9967E] mt-4 text-lg">Pilih kamar yang sesuai kebutuhanmu</p>
            </div>

            <div class="mb-6 flex flex-wrap justify-between gap-3">
                <input
                    type="text"
                    id="searchInput"
                    placeholder="Cari nama kamar..."
                    oninput="filterKamar()"
                    class="rounded-lg px-6 py-3 text-sm bg-white shadow-lg focus:ring-2 focus:ring-[#F58A8A] w-[750px] border border-slate-200 outline-none">
                
                    <button onclick="setFilter('semua', this)" 
                    class="filter-btn px-6 py-3 rounded-2xl text-sm font-bold bg-[#F58A8A] text-white shadow-sm transition">
                    Semua
                </button>

                @foreach(App\Models\InformasiKamar::select('lantai')->distinct()->orderBy('lantai')->pluck('lantai') as $lt)
                    <button onclick="setFilter('{{ $lt }}', this)" 
                        class="filter-btn px-6 py-3 rounded-2xl text-sm font-bold bg-white text-[#F58A8A] shadow-sm hover:bg-[#F58A8A] hover:text-white transition">
                        Lantai {{ $lt }}
                    </button>
                @endforeach
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <style>
                    .kamar-swiper .swiper-slide img {
                        filter: none;
                        transform: none;
                    }
                </style>
                @foreach ($kamars as $kamarItem)
                <div
                    class="kamar-card bg-white rounded-xl overflow-hidden shadow-md border border-slate-200 hover:shadow-xl hover:-translate-y-1 transition-all duration-300"
                    data-nama="{{ strtolower($kamarItem->nama_kamar) }}"
                    data-lantai="{{ $kamarItem->lantai }}"
                >
                    <!-- SWIPER GAMBAR -->
                    <div class="swiper kamar-swiper w-full h-52">
                        <div class="swiper-wrapper">
                            @forelse ($kamarItem->gambars as $gambar)
                                <div class="swiper-slide">
                                    <a href="{{ asset('storage/' . $gambar->gambar) }}" class="glightbox" data-gallery="kamar-{{ $kamarItem->id }}">
                                        <img
                                            src="{{ asset('storage/' . $gambar->gambar) }}"
                                            class="w-full h-52 object-cover"
                                            alt="{{ $kamarItem->nama_kamar }}">
                                    </a>
                                </div>
                            @empty
                                <div class="swiper-slide">
                                    <div class="w-full h-52 bg-slate-100 flex items-center justify-center text-slate-400 text-sm">
                                        Tidak ada gambar
                                    </div>
                                </div>
                            @endforelse
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-xl font-black text-slate-800">{{ $kamarItem->nama_kamar }}</h3>
                            <span class="text-xs font-semibold bg-[#DDFBFF] text-[#54D8E3] px-3 py-1 rounded-full">
                                Lantai {{ $kamarItem->lantai }}
                            </span>
                        </div>

                        <p class="text-slate-500 text-sm mb-4 leading-relaxed">{{ $kamarItem->deskripsi }}</p>

                        <div class="flex items-end justify-between border-t border-slate-100 pt-4">
                            <div>
                                <p class="text-xs text-slate-400 mb-1">Harga per bulan</p>
                                <p class="text-2xl font-black text-[#54D8E3]">Rp {{ number_format($kamarItem->harga, 0, ',', '.') }}</p>
                            </div>
                            <a href="/login"
                                class="bg-[#ffb453] text-white text-sm font-bold px-5 py-2 rounded-2xl hover:scale-105 transition inline-block">
                                Pesan
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </section>
    <script>
        let activeFilter = 'semua';
        const searchInput = document.getElementById('searchInput');

        let swipers = [];

        document.addEventListener('DOMContentLoaded', () => {
            initSwipers();
            filterKamar();
        });


        function initSwipers() {
            document.querySelectorAll('.kamar-swiper').forEach((el) => {
                const swiper = new Swiper(el, {
                    slidesPerView: 1,
                    loop: true,
                    speed: 800,

                    autoplay: {
                        delay: 2000,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: false,
                    },
                });

                swipers.push(swiper);
            });
        }


        /* FILTER BUTTON */
        function setFilter(val, el) {
            activeFilter = val;

            document.querySelectorAll('.filter-btn').forEach(b => {
                b.classList.remove('bg-[#F58A8A]', 'text-white');
                b.classList.add('bg-white', 'text-[#F58A8A]');
            });

            el.classList.add('bg-[#F58A8A]', 'text-white');
            el.classList.remove('bg-white', 'text-[#F58A8A]');

            filterKamar();
        }


        /* FILTER LOGIC + SWIPER RESET */
        function filterKamar() {
            const q = (searchInput?.value || '').toLowerCase().trim();

            document.querySelectorAll('.kamar-card').forEach(card => {
                const nama = (card.dataset.nama || '').toLowerCase();
                const lantai = String(card.dataset.lantai);

                const show =
                    nama.includes(q) &&
                    (activeFilter === 'semua' || lantai === activeFilter);

                card.style.display = show ? '' : 'none';
            });

            requestAnimationFrame(() => {

                // stop swiper lama
                swipers.forEach(s => {
                    s.autoplay.stop();
                    s.destroy(true, true);
                });

                // kosongkan array
                swipers = [];

                // re-init swiper
                initSwipers();
            });
        }


        /* SEARCH */
        searchInput?.addEventListener('input', filterKamar);
    </script>

    <!-- SYARAT & PERATURAN -->
    <section id="syarat" class="scroll-mt-7 py-10 bg-white py-20">
        <div class="max-w-4xl mx-auto px-6">

            <div class="text-center mb-12">
                <h2 class="text-5xl font-black text-slate-800">Syarat & Peraturan</h2>
                <p class="text-slate-500 mt-4 text-lg">Harap dibaca sebelum memesan kamar</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

                <!-- SYARAT MASUK -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-lg">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-2xl bg-[#DDD2FF] flex items-center justify-center text-lg">📋</div>
                        <h3 class="font-black text-slate-800">Syarat Masuk</h3>
                    </div>
                    <ul class="space-y-2 text-sm text-slate-500">
                        <li>• Kos campur, untuk putra dan putri </li>
                        <li>• Mengisi data diri </li>
                        <li>• Mengisi formulir pendaftaran</li>
                        <li>• Membayar bulan pertama di muka</li>
                    </ul>
                </div>

                <!-- PERATURAN HARIAN -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-lg">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-2xl bg-[#DDFBFF] flex items-center justify-center text-lg">🕐</div>
                        <h3 class="font-black text-slate-800">Peraturan Harian</h3>
                    </div>
                    <ul class="space-y-2 text-sm text-slate-500">
                        <li>• Jam malam pukul 22.00 WIB</li>
                        <li>• Tamu hanya boleh di lobby hingga pukul 21.00 WIB</li>
                        <li>• Jaga kebersihan kamar dan area bersama</li>
                        <li>• Tidak boleh berisik mengganggu penghuni lain</li>
                    </ul>
                </div>

                <!-- LARANGAN -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-lg">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-2xl bg-[#FFD8D1] flex items-center justify-center text-lg">🚫</div>
                        <h3 class="font-black text-slate-800">Larangan</h3>
                    </div>
                    <ul class="space-y-2 text-sm text-slate-500">
                        <li>• Dilarang merokok di dalam kamar</li>
                        <li>• Dilarang membawa tamu menginap</li>
                        <li>• Dilarang membawa hewan peliharaan</li>
                        <li>• Dilarang membawa minuman keras</li>
                    </ul>
                </div>

                <!-- PEMBAYARAN -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-lg">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-2xl bg-[#DDD2FF] flex items-center justify-center text-lg">💳</div>
                        <h3 class="font-black text-slate-800">Pembayaran</h3>
                    </div>
                    <ul class="space-y-2 text-sm text-slate-500">
                        <li>• Pembayaran setiap tanggal 1-5 tiap bulan</li>
                        <li>• Maksimal menunggak 1 bulan</li>
                        <li>• Pembayaran via transfer</li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-[#A9DBDC] pt-16">
        <div class="max-w-7xl mx-auto px-6">

            <div class="grid grid-cols-5 gap-10 mb-12 place-items-start">

                <!-- LOGO & DESKRIPSI -->
                <div>
                    <img src="{{ asset('images/logo.svg') }}" alt="di-kos logo" class="h-14 w-auto mb-4">
                    <p class="text-sm text-slate-600 leading-relaxed">
                        di-kos. menghadirkan pengalaman tinggal yang nyaman, bersih, modern, dan aman untuk mahasiswa maupun pekerja.
                    </p>
                </div>

                <div></div>

                <!-- INFORMASI -->
                <div>
                    <h4 class="font-black text-slate-800 mb-4">Informasi</h4>
                    <div class="space-y-2">

                        <div>
                            <button onclick="toggleFooterAccordion(this)" class="flex items-center gap-2 text-sm text-slate-600 hover:text-slate-800 transition w-full text-left">
                                <svg class="w-3 h-3 transition-transform duration-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                Tentang Kami
                            </button>
                            <div class="footer-accordion max-h-0 overflow-hidden transition-all duration-300 ml-5 text-xs text-slate-500 leading-relaxed text-justify">
                                di-kos. adalah kos unik dan modern. Kami hadir untuk memberikan hunian nyaman, bersih, dan aman bagi mahasiswa maupun pekerja.
                            </div>
                        </div>

                        <div>
                            <button onclick="toggleFooterAccordion(this)" class="flex items-center gap-2 text-sm text-slate-600 hover:text-slate-800 transition w-full text-left">
                                <svg class="w-3 h-3 transition-transform duration-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                Kebijakan Privasi
                            </button>
                            <div class="footer-accordion max-h-0 overflow-hidden transition-all duration-300 ml-5 text-xs text-slate-500 leading-relaxed text-justify">
                                Data pribadi penghuni hanya digunakan untuk keperluan administrasi kos dan tidak akan disebarkan kepada pihak ketiga tanpa izin.
                            </div>
                        </div>

                        <div>
                            <button onclick="toggleFooterAccordion(this)" class="flex items-center gap-2 text-sm text-slate-600 hover:text-slate-800 transition w-full text-left">
                                <svg class="w-3 h-3 transition-transform duration-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                Syarat & Ketentuan
                            </button>
                            <div class="footer-accordion max-h-0 overflow-hidden transition-all duration-300 ml-5 text-xs text-slate-500 leading-relaxed text-justify">
                                Penghuni wajib mematuhi semua peraturan yang berlaku. Pelanggaran dapat mengakibatkan denda.
                            </div>
                        </div>

                    </div>
                </div>

                <div></div>

                <!-- HUBUNGI KAMI -->
                <div>
                    <h4 class="font-black text-slate-800 mb-4">Hubungi Kami</h4>
                    <ul class="space-y-3 text-sm text-slate-600">

                        <li>
                            <a href="https://wa.me/6282179622877" target="_blank" class="flex items-center gap-3 hover:text-slate-800 transition">
                                <div class="w-9 h-9 rounded-full bg-white/60 flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-700" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                </div>
                                082179622877
                            </a>
                        </li>

                        <li>
                            <a href="mailto:endiazalalkawi@gmail.com" class="flex items-center gap-3 hover:text-slate-800 transition">
                                <div class="w-9 h-9 rounded-full bg-white/60 flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                endiazalalkawi@gmail.com
                            </a>
                        </li>

                        <li>
                            <a href="https://instagram.com/endi_azila_alkawi" target="_blank" class="flex items-center gap-3 hover:text-slate-800 transition">
                                <div class="w-9 h-9 rounded-full bg-white/60 flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-700" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </div>
                                @endi_azila_alkawi
                            </a>
                        </li>

                        <li>
                            <a href="#lokasi" class="flex items-center gap-3 hover:text-slate-800 transition">
                                <div class="w-9 h-9 rounded-full bg-white/60 flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                Dekat Universitas Negeri Padang (UNP)
                            </a>
                        </li>

                    </ul>
                </div>

            </div>

        </div>

        <!-- COPYRIGHT -->
        <div class="bg-[#9AC0C1] py-5 text-center text-sm text-slate-600">
            © {{ date('Y') }} <span class="font-bold">di-kos.</span> All Rights Reserved
        </div>

    </footer>
    <script>
        function toggleFooterAccordion(btn) {
            const content = btn.nextElementSibling;
            const icon = btn.querySelector('svg');
            const isOpen = content.style.maxHeight && content.style.maxHeight !== '0px';

            document.querySelectorAll('.footer-accordion').forEach(el => {
                el.style.maxHeight = '0px';
                el.previousElementSibling.querySelector('svg').classList.remove('rotate-90');
            });

            if (!isOpen) {
                content.style.maxHeight = content.scrollHeight + 'px';
                icon.classList.add('rotate-90');
            }
        }
    </script>

    <script>
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.nav-link');

        window.addEventListener('scroll', () => {

            let current = '';

            sections.forEach(section => {
                const sectionTop = section.offsetTop - 150;
                const sectionHeight = section.offsetHeight;

                if (window.scrollY >= sectionTop) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');

                if (link.getAttribute('href') === '#' + current) {
                    link.classList.add('active');
                }
            });

        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.lightbox = GLightbox({
                selector: '.glightbox',
                touchNavigation: true,
                loop: true,
                closeButton: true
            });
        });
    </script>
</div>