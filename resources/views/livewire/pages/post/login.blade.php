<!DOCTYPE html>
<html>
    <head>
        <title>Auth</title>
        @vite('resources/css/app.css')
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <style>
            [x-cloak]{
                display:none !important;
            }

            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(60px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .auth-card {
                animation: slideUp 0.4s ease-out;
            }
        </style>
    </head>

    <body
        class="min-h-screen bg-cover bg-center bg-no-repeat"
        style="background-image: url('{{ asset('images/gedung (2).png') }}');"
    >
            <!-- NAVBAR -->
        <div class="fixed top-0 left-0 z-50 w-full">

            <!-- TOP BAR -->
            <div id="top-bar" class="bg-[#A9DBDC] transition-all duration-300 pl-9">
                <div class="flex h-10 items-center justify-between px-7 text-slate-600">

                    <div class="flex items-center gap-4">

                        <a href="https://mail.google.com/mail/?view=cm&fs=1&to=endiazalalkawi@gmail.com"
                        class="flex text-xs items-center gap-1 text-[#F9F9F9]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>endiazalalkawi@gmail.com</span>
                        </a>

                        <span class="text-[#F9F9F9]/50">|</span>

                        <a href="https://wa.me/6282179622877"
                        target="_blank"
                        class="flex items-center text-xs gap-1 text-[#F9F9F9]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-[#F9F9F9]" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            <span>082179622877</span>
                        </a>

                    </div>

                </div>
            </div>

            <!-- HEADER -->
            <header class="w-full border-b border-slate-200 bg-white">

                <nav class="flex items-center justify-between px-16 py-3">

                    <!-- LOGO -->
                    <div class="flex items-center flex-1">
                        <img src="{{ asset('images/logo.svg') }}"
                            alt="di-kos logo"
                            class="h-14 w-40">
                    </div>

                    <!-- BUTTON KEMBALI -->
                    <div class="flex-1 flex justify-end">
                        <a href="/landing_page"
                        class="rounded-xl bg-[#F58A8A] px-6 py-3 text-sm font-bold text-white transition hover:scale-105">
                            ← Kembali
                        </a>
                    </div>

                </nav>

            </header>

        </div>

        <div class="min-h-screen flex items-center justify-center px-6">


            <!-- AUTH CARD -->
            <div
                x-cloak
                x-data="{
                    isLogin: {{ $errors->any() ? 'false' : (session('registered') ? 'false' : 'true') }}
                }"
                x-init="
                    @if(session('registered'))
                        setTimeout(() => {
                            isLogin = true
                        }, 1200)
                    @endif
                "
                class="auth-card relative top-10 w-full max-w-5xl bg-white rounded-[2.5rem] shadow-2xl overflow-hidden"
            >

                <!-- TRACK -->
                <div
                    class="flex w-[200%] transition-transform duration-700 ease-in-out"
                    :class="isLogin ? 'translate-x-0' : '-translate-x-1/2'"
                >

                    <!-- ================= LOGIN ================= -->
                    <div class="w-1/2 flex">

                        <div class="w-[60%] flex items-center justify-center p-12">
                            <form method="POST" action="/login" class="w-full space-y-5">
                                @csrf

                                <h1 class="text-3xl font-black text-slate-800">Login</h1>

                                <p class="text-slate-400 text-sm">
                                    Masuk untuk melanjutkan ke dashboard
                                </p>

                                <input type="email" name="email" placeholder="Email"
                                    class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#F58A8A] outline-none">
                                

                                <input type="password" name="password" placeholder="Password"
                                    class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#F58A8A] outline-none">

                                <button class="w-full bg-[#F58A8A] hover:scale-[1.02] transition text-white font-bold py-3 rounded-xl">
                                    Login
                                </button>
                            </form>
                        </div>

                        <div class="w-[40%] bg-[#F58A8A] text-white flex flex-col justify-center p-10">
                            <h2 class="text-2xl font-black mb-3">Belum punya akun?</h2>

                            <p class="text-white/80 text-sm mb-6">
                                Daftar sekarang untuk mulai pesan kamar
                            </p>

                            <button
                                type="button"
                                @click="isLogin = false"
                                class="bg-white text-[#F58A8A] font-bold px-5 py-2 rounded-xl w-fit hover:scale-105 transition">
                                Daftar
                            </button>
                        </div>

                    </div>

                    <!-- ================= REGISTER ================= -->
                    <div class="w-1/2 flex">

                        <div class="w-[40%] bg-[#A9DBDC] text-white flex flex-col justify-center p-10">
                            <h2 class="text-2xl font-black mb-3">Sudah punya akun?</h2>

                            <p class="text-white/80 text-sm mb-6">
                                Login untuk lanjut ke dashboard
                            </p>

                            <button
                                type="button"
                                @click="isLogin = true"
                                class="bg-white text-[#A9DBDC] font-bold px-5 py-2 rounded-xl w-fit hover:scale-105 transition">
                                Login
                            </button>
                        </div>

                        <div class="w-[60%] flex items-center justify-center p-12">
                            <form method="POST" action="/register" class="w-full space-y-5">
                                @csrf

                                <h1 class="text-3xl font-black text-slate-800">Register</h1>

                                <p class="text-slate-400 text-sm">
                                    Buat akun baru untuk mulai
                                </p>

                                <input type="text" name="name" placeholder="Nama"
                                    class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#6ED6DB] outline-none">

                                <input type="email" name="email" placeholder="Email"
                                    class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#6ED6DB] outline-none">

                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror

                                <input type="password" name="password" placeholder="Password"
                                    class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#6ED6DB] outline-none">

                                <button class="w-full bg-[#A9DBDC] hover:scale-[1.02] transition text-white font-bold py-3 rounded-xl">
                                    Daftar
                                </button>
                            </form>
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </body>
</html>