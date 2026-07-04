<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Admin Dashboard - di-kos.</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <style>

            html { scroll-behavior: smooth; }

            body { font-family: 'Inter', sans-serif; }

            ::-webkit-scrollbar { width: 4px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: rgba(99,102,241,.4); border-radius: 99px; }

            ::-webkit-scrollbar {
                width: 5px;
            }

            ::-webkit-scrollbar-track {
                background: #e2e8f0;
            }

            ::-webkit-scrollbar-thumb {
                background: rgba(99,102,241,.4)
                border-radius: 999px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: rgba(99,102,241,.4)
            }

            @keyframes fade {
                from { opacity: 0; transform: translateY(6px); }
                to   { opacity: 1; transform: translateY(0); }
            }

            .animate-fade { animation: fade .25s ease; }

            .nav-item {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 9px 12px;
                border-radius: 10px;
                color: rgba(0, 60, 60, 0.75);
                font-size: 13px;
                font-weight: 500;
                text-decoration: none;
                transition: all 0.18s ease;
                border-left: 3px solid transparent;
            }

            /* HOVER - sedikit gelap + glass teal */
            .nav-item:hover {
                background: rgba(0, 80, 80, 0.12);
                color: #004d4d;
            }

            /* ACTIVE - lebih gelap dari background */
            .nav-item.active {
                background: rgba(0, 70, 70, 0.25);
                color: #003c3c;
                font-weight: 600;
                border-left-color: #005a5a;
                padding-left: 9px;
            }

            /* BUTTON */
            .nav-item-btn {
                width: 100%;
                background: none;
                border: none;
                text-align: left;
                cursor: pointer;
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 9px 12px;
                border-radius: 10px;
                color: rgba(0, 60, 60, 0.75);
                font-size: 13px;
                font-weight: 500;
                transition: all 0.18s ease;
            }

            .nav-item-btn:hover {
                background: rgba(0, 80, 80, 0.12);
                color: #004d4d;
            }

            .nav-item-btn.active {
                background: rgba(0, 70, 70, 0.25);
                color: #003c3c;
                font-weight: 600;
            }

            /* SUB ITEM */
            .sub-item {
                display: block;
                font-size: 12px;
                padding: 7px 10px;
                border-radius: 8px;
                color: rgba(0, 60, 60, 0.65);
                text-decoration: none;
                transition: all 0.15s ease;
            }

            .sub-item:hover {
                background: rgba(0, 80, 80, 0.12);
                color: #004d4d;
            }

            .sub-item.active {
                background: rgba(0, 70, 70, 0.22);
                color: #003c3c;
                font-weight: 600;
            }

            /* SECTION LABEL */
            .section-label {
                font-size: 10px;
                font-weight: 700;
                letter-spacing: 0.14em;
                color: rgba(0, 60, 60, 0.7);
                margin: 14px 0 6px;
                padding: 0 8px;
                text-transform: uppercase;
            }

            .section-label:first-child { margin-top: 0; }

        </style>

        @php
            $jumlahPengaduan = \App\Models\Pengaduan::where('status', '!=', 'selesai')->count();
        @endphp
    </head>

    <body class="bg-[white] text-slate-800 min-h-screen">

        <!-- ═══════════════ NAVBAR ═══════════════ -->
        <nav class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-slate-200 h-20 flex items-center justify-between px-6 shadow-sm pt-3">

            <!-- BRAND -->
            <div class="flex items-center gap-10 ">

                <div class="flex items-center">

                    <img
                        src="{{ asset('images/logo.svg') }}"
                        alt="di-kos logo"
                        class="h-14 w-40">

                </div>
                <div class="w-px h-5 bg-slate-200"></div>
                <span class="text-xs text-slate-500 font-medium"> Admin Panel</span>

            </div>

            <!-- RIGHT -->
            <div class="flex items-center gap-4">

                <!-- NOTIF -->
                <div class="relative cursor-pointer">
                    <svg class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/>
                    </svg>
                    <span class="absolute -top-0.5 -right-0.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                </div>

                <div class="w-px h-5 bg-slate-200"></div>

                <!-- USER -->
             
                @auth
                <div x-data="{ open: false }" class="relative">

                    <!-- USER BUTTON -->
                    <div @click="open = !open"
                        class="flex items-center gap-2.5 cursor-pointer select-none">

                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white"
                            style="background: linear-gradient(135deg, #4f46e5, #7c3aed);">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                        </div>

                        <div>
                            <p class="text-xs font-semibold text-slate-800 leading-none">
                                {{ auth()->user()->name ?? 'Guest' }}
                            </p>
                        </div>

                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"/>
                        </svg>

                    </div>

                    <!-- DROPDOWN -->
                    <div x-show="open"
                        @click.outside="open = false"
                        x-transition
                        class="absolute right-0 mt-3 w-48 bg-white border border-slate-200 rounded-xl shadow-lg overflow-hidden z-50">

                        <a href="/admin/profil"
                            class="block px-4 py-2 text-sm hover:bg-slate-100">
                            Profil
                        </a>

                        <form method="POST" action="/logout">
                            @csrf
                            <button class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50">
                                Logout
                            </button>
                        </form>

                    </div>

                </div>
                @endauth
            </div>

        </nav>

        <!-- ═══════════════ SIDEBAR ═══════════════ -->
        <aside class="sidebar fixed top-14 left-0 z-40 w-56 h-[calc(100vh-3.5rem)] bg-[#A9DBDC] ">
 
            <!-- MENU -->
            <div class="flex-1 overflow-y-auto px-3 py-3 pt-12">

                <span class="section-label">Menu</span>

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="nav-item mb-0.5 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linejoin="round" d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.5z"/>
                        <path stroke-linejoin="round" d="M9 21V12h6v9"/>
                    </svg>
                    Dashboard
                </a>

                <span class="section-label">Kamar</span>

                <!-- KELOLA KAMAR -->
                <div x-data="{ open: localStorage.getItem('kelola-kamar-open') === 'true' }">

                    <button
                        @click="open = !open; localStorage.setItem('kelola-kamar-open', open)"
                        class="nav-item-btn mb-0.5 {{ request()->routeIs(['admin.informasi_kamar','admin.data_kamar','admin.konfirmasi_bayar','admin.histori_pembayaran']) ? 'active' : '' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <rect x="2" y="7" width="20" height="14" rx="2" stroke="currentColor" stroke-width="1.8"/>
                            <path stroke-linecap="round" d="M2 12h20M8 7V5M16 7V5"/>
                        </svg>
                        <span class="flex-1 text-left">Kelola Kamar</span>
                        <svg class="w-3 h-3 flex-shrink-0 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" d="M6 9l6 6 6-6"/>
                        </svg>
                    </button>

                    <div
                        x-show="open"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="ml-6 pl-3 mb-1 space-y-0.5"
                        style="border-left: 1px solid rgba(255,255,255,0.1);">

                        <a href="{{ route('admin.informasi_kamar') }}"
                           class="sub-item {{ request()->routeIs('admin.informasi_kamar') ? 'active' : '' }}">
                            Informasi Kamar
                        </a>
                        <a href="{{ route('admin.data_kamar') }}"
                           class="sub-item {{ request()->routeIs('admin.data_kamar') ? 'active' : '' }}">
                            Data Kamar
                        </a>
                        <a href="{{ route('admin.konfirmasi_bayar') }}"
                           class="sub-item {{ request()->routeIs('admin.konfirmasi_bayar') ? 'active' : '' }}">
                            Konfirmasi Bayar
                        </a>
                        <a href="{{ route('admin.histori_pembayaran') }}"
                           class="sub-item {{ request()->routeIs('admin.histori_pembayaran') ? 'active' : '' }}">
                            Histori Pembayaran
                        </a>

                    </div>

                </div>

                <span class="section-label">Lainnya</span>

                <!-- KONFIRMASI -->
                <a href="{{ route('admin.konfirmasi') }}" class="nav-item mb-0.5 {{ request()->routeIs('admin.konfirmasi') ? 'active' : '' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7 3H4a1 1 0 00-1 1v16a1 1 0 001 1h16a1 1 0 001-1V4a1 1 0 00-1-1h-3M9 3h6v4H9V3z"/>
                    </svg>
                    Konfirmasi
                </a>

                <!-- ADUAN -->
                <a href="{{ route('admin.daftar_pengaduan') }}" class="nav-item mb-0.5 {{ request()->routeIs('admin.daftar_pengaduan') ? 'active' : '' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/>
                    </svg>
                    <span class="flex-1">Aduan</span>
                    @if($jumlahPengaduan > 0)
                        <span class="text-[9px] font-bold text-white px-1.5 py-0.5 rounded-full" style="background: #003c3c;">
                            {{ $jumlahPengaduan }}
                        </span>
                    @endif
                </a>

                <!-- PENGUMUMAN -->
                <a href="{{ route('admin.pengumuman') }}" class="nav-item mb-0.5 {{ request()->routeIs('admin.pengumuman') ? 'active' : '' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 010 12.728M16.463 8.288a5.25 5.25 0 010 7.424M6.75 8.25l4.72-4.72a.75.75 0 011.28.53v15.88a.75.75 0 01-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.01 9.01 0 012.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75z" />
                    </svg>
                    Kelola Pengumuman
                </a>

            </div>

        </aside>

        <!-- ═══════════════ CONTENT ═══════════════ -->
        <main class="main-content ml-56 pt-24 min-h-screen flex flex-col animate-fade relative z-10">

    <div class="p-6 flex-1">
        {{ $slot }}
    </div>

    <footer class="bg-[#9AC0C1] py-5 text-center text-sm text-slate-700">
        © {{ date('Y') }} <span class="font-bold">di-kos.</span> All Rights Reserved
    </footer>

</main>

        @livewireScripts

    </body>
    
</html>