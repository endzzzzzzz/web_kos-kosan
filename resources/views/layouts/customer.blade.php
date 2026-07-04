<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>di-kos. — {{ $title ?? 'Customer' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <!-- GLightbox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css"/>
    <style>
        
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-thumb { background: rgba(99,102,241,.4); border-radius: 999px; }

        :root {
            --cyan: #9de6e9;
            --cyan-dark: #54D8E3;
            --purple: #8B6DFF;
            --purple-light: #DDD2FF;
            --pink: #F58A8A;
            --orange: #ffb453;
            --text-dark: #1e293b;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #F7FAFF;
            color: var(--text-dark);
            min-height: 100vh;
        }

        #navbar {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 100;
            transition: box-shadow 0.3s;
        }

        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 4rem; /* sama seperti px-16 */
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: .5rem;
            margin-left: auto;
        }

        .nav-logo {
            font-size: 1.5rem;
            font-weight: 900;
            color: var(--text-dark);
            letter-spacing: -0.5px;
            text-decoration: none;
        }

        .nav-logo span { color: var(--cyan-dark); }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            list-style: none;
        }

        .nav-menu a {
            display: flex;
            align-items: center;
            gap: 8px;

            padding: 0.5rem 1rem;
            border-radius: 12px;

            font-size: 0.85rem;
            font-weight: 600;
            line-height: 1;

            color: var(--text-muted);
            text-decoration: none;

            transition: background 0.2s, color 0.2s;
        }

        .nav-menu a svg {
            width: 18px;
            height: 18px;
            stroke-width: 2;
            flex-shrink: 0;
            position: relative;
            top: -1px; /* geser sedikit ke atas */
        }

        .nav-menu a:hover {
            background: #f1f5f9;
            color: var(--text-dark);
        }

        .nav-menu a.active {
            background: var(--purple-light);
            color: var(--purple);
        }

        .nav-notif {
            position: relative;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 12px;
            transition: background 0.2s;
            color: var(--text-muted);
            display: flex;
            align-items: center;
        }

        .nav-notif:hover { background: #f1f5f9; color: var(--text-dark); }

        .notif-dot {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 8px;
            height: 8px;
            background: var(--pink);
            border-radius: 50%;
            border: 2px solid white;
        }

        .nav-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.4rem 0.75rem 0.4rem 0.4rem;
            border-radius: 14px;
            border: 1.5px solid #e2e8f0;
            cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
            position: relative;
            user-select: none;
        }

        .nav-profile:hover {
            border-color: var(--cyan-dark);
            background: #f8fffe;
        }

        .profile-avatar {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            background: var(--purple-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 13px;
            color: var(--purple);
        }

        .profile-name {
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .profile-status {
            font-size: 0.7rem;
            font-weight: 600;
            color: #10b981;
        }

        .profile-status.pending { color: var(--orange); }
        .profile-status.inactive { color: var(--text-muted); }

        .profile-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: white;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            min-width: 210px;
            overflow: hidden;
            z-index: 200;
        }

        .profile-dropdown.open { display: block; }

        .dropdown-header {
            padding: 1rem 1.25rem;
            background: var(--purple-light);
        }

        .dropdown-header p { font-size: 0.82rem; font-weight: 800; color: var(--purple); }
        .dropdown-header span { font-size: 0.72rem; color: #6d5bd0; }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.7rem 1.25rem;
            font-size: 0.83rem;
            font-weight: 600;
            color: var(--text-muted);
            cursor: pointer;
            transition: background 0.15s, color 0.15s;
            text-decoration: none;
        }

        .dropdown-item:hover { background: #f8faff; color: var(--text-dark); }
        .dropdown-item svg { width: 16px; height: 16px; flex-shrink: 0; }
        .dropdown-item.logout { color: var(--pink); }
        .dropdown-item.logout:hover { background: #fff5f5; }
        .dropdown-divider { height: 1px; background: #f1f5f9; }

        .nav-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border-radius: 12px;
            color: #475569; /* slate-600 */
            transition: 0.2s;
        }

        .nav-menu a svg {
            width: 20px;
            height: 20px;
            stroke: #94a3b8; /* slate-400 */
        }

        .nav-menu a.nav-active {
            background: #f1f5f9; /* slate-100 */
            color: #0f172a; /* slate-900 */
            font-weight: 600;
        
        }

        .nav-menu a.nav-active svg {
            stroke: #0f172a;
        }
    </style>
</head>

<body>

    <!-- TOP BAR -->
    <div class="fixed top-0 left-0 z-50 w-full">
        <div id="top-bar" class="bg-[#9AC0C1] transition-all duration-300 pl-9">
            <div class="flex h-10 items-center justify-between px-7 text-slate-600">

                <!-- Bagian Kontak (Kiri) -->
                <div class="flex items-center gap-4">

                    <!-- Email -->
                    <a href="https://mail.google.com/mail/?view=cm&fs=1&to=endiazalalkawi@gmail.com" class="flex text-xs items-center gap-1 text-[#F9F9F9]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#F9F9F9]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>endiazalalkawi@gmail.com</span>
                    </a>

                    <span class="text-[#F9F9F9]/50">|</span>

                    <!-- WhatsApp -->
                    <a href="https://wa.me/6282179622877" target="_blank" class="flex items-center text-xs gap-1 hover:text-emerald-600 transition-colors text-[#F9F9F9]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-[#F9F9F9]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        <span>082179622877</span>
                    </a>
                </div>
                
            </div>
        </div>

        <!-- NAVBAR -->
        <nav id="navbar">
            <div class="nav-inner">

                <!-- LOGO -->
                <div class="flex items-center flex-1 ">
                    <img src="{{ asset('images/logo.svg') }}" alt="di-kos logo" class="h-14 w-40">
                </div>

                <!-- Kanan -->
                <div class="nav-right">

                    <ul class="nav-menu">

                        <li>
                            <a href="{{ route('customer.dashboard') }}"
                            class="{{ request()->routeIs('customer.dashboard') ? 'nav-active' : '' }}">

                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 3l9 6.75V21H3V9.75z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 21V12h6v9"/>
                                </svg>

                                Dashboard
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('customer.kamar') }}"
                            class="{{ request()->routeIs('customer.kamar') ? 'nav-active' : '' }}">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12V7a1 1 0 011-1h4a1 1 0 011 1v5"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2 17v-5h20v5"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2 17v2m20-2v2"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2 12h20"/>
                                </svg>

                                Kamar
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('customer.booking') }}"
                            class="{{ request()->routeIs('customer.booking') ? 'nav-active' : '' }}">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/>
                                </svg>

                                Booking
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('customer.pembayaran') }}"
                            class="{{ request()->routeIs('customer.pembayaran') ? 'nav-active' : '' }}">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>

                                Pembayaran
                            </a>
                        </li>

                    </ul>

                    <!-- Notifikasi -->
                    <a href="https://wa.me/6282179622877" target="_blank" class="relative inline-flex items-center group">

                        <!-- ICON -->
                        <div class="p-2 rounded-full  hover:bg-slate-200 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                                    
                        </div>

                        <!-- TOOLTIP (BOTTOM) -->
                        <span class="absolute top-full mt-2 left-1/2 -translate-x-1/2
                                    bg-white text-slate-800 text-xs px-3 py-1 rounded-lg shadow-md border border-slate-200
                                    opacity-0 scale-95
                                    group-hover:opacity-100 group-hover:scale-100
                                    transition whitespace-nowrap pointer-events-none">
                            Chat Admin
                        </span>

                    </a>

                    <!-- Profil Dropdown -->
                    <div class="nav-profile" id="profileToggle" onclick="toggleDropdown()">
                        @auth
                            <div class="profile-avatar">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>

                            <div>
                                <div class="profile-name">
                                    {{ auth()->user()->name }}
                                </div>                              
                            </div>
                        @else
                            <div class="profile-avatar">?</div>
                            <div>
                                <div class="profile-name">Guest</div>
                                <div class="profile-status">● Belum Login</div>
                            </div>
                        @endauth
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="color:#94a3b8; margin-left:4px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>

                        <!-- Dropdown Menu -->
                        <div class="profile-dropdown" id="profileDropdown">
                            <div class="dropdown-header">
                                @auth
                                    <p>{{ auth()->user()->name }}</p>
                                    <span>{{ auth()->user()->email }}</span>
                                @else
                                    <p>Guest</p>
                                    <span>Belum login</span>
                                @endauth
                            </div>
                            <a class="dropdown-item" href="{{ route('customer.profil') }}">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Profil Saya
                            </a>
                            <a class="dropdown-item" href="{{ route('customer.pengaduan') }}">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/>
                                </svg>
                                Pengaduan
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="/logout">
                                @csrf
                                <button type="submit" class="dropdown-item logout" style="width:100%; border:none; background:none; text-align:left; cursor:pointer; font-family:inherit;">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </nav>
    </div>

    <!-- CONTENT -->
    <main class="pt-[112px]">
        {{ $slot }}
    </main>

    <script>
        function toggleDropdown() {
            document.getElementById('profileDropdown').classList.toggle('open');
        }

        document.addEventListener('click', function(e) {
            const profileToggle = document.getElementById('profileToggle');

            if (profileToggle && !profileToggle.contains(e.target)) {
                document.getElementById('profileDropdown')
                    ?.classList.remove('open');
            }
        });

        const navbar = document.getElementById('navbar');
    </script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- GLightbox JS -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
</body>
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
                            <a href="https://www.google.com/maps/place/Universitas+Negeri+Padang/@-0.8974544,100.3490739,435m/data=!3m1!1e3!4m10!1m2!2m1!1sunp!3m6!1s0x2fd4b8accb64ea31:0x9e6d3a9be19372d1!8m2!3d-0.8969727!4d100.3502358!15sCgN1bnBaBSIDdW5wkgERcHVibGljX3VuaXZlcnNpdHmaASNDaFpEU1VoTk1HOW5TMFZKUTBGblNVUmxhWEJtZGt0UkVBReABAPoBBAgAEEA!16s%2Fg%2F119vrt7bk?entry=ttu&g_ep=EgoyMDI2MDYxMC4wIKXMDSoASAFQAw%3D%3D" 
                            target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 hover:text-slate-800 transition">
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
</html>