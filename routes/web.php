<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

Route::get('/register', function () {
    return view('pages.post.register');
});

Route::post('/register', function (Request $request) {
    
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'user' // penting ini
    ]);


    return back()->with('registered', true);
});

Route::get('/login', function () {
    return view('pages.post.login');
});

Route::post('/login', function (Request $request) {

    if (Auth::attempt($request->only('email', 'password'))) {

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        return redirect('/customer/dashboard');
    }

    return back()->with('error', 'Login gagal');
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/landing_page');
});

Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/admin', '/admin/dashboard');

Volt::route('/admin/dashboard', 'pages.post.admin.dashboard_admin')
    ->name('admin.dashboard');

Volt::route('/admin/profil', 'pages.post.admin.profil')
    ->name('admin.profil');

Volt::route('/admin/informasi_kamar', 'pages.post.admin.informasi_kamar')
    ->name('admin.informasi_kamar');

Volt::route('/admin/tambah-informasi-kamar', 'pages.post.admin.tambah_informasi_kamar')
    ->name('admin.tambah_informasi_kamar');

Volt::route('/admin/edit_informasi_kamar/{id}', 'pages.post.admin.edit_informasi_kamar')
    ->name('admin.edit_informasi_kamar');

Volt::route('/admin/tambah_data_kamar', 'pages.post.admin.tambah_data_kamar')
    ->name('admin.tambah_data_kamar');

Volt::route('/admin/data_kamar', 'pages.post.admin.data_kamar')
    ->name('admin.data_kamar');

Volt::route('/admin/edit_data_kamar/{id}', 'pages.post.admin.edit_data_kamar')
    ->name('admin.edit_data_kamar');

Volt::route('/admin/tambah_penghuni/{id}', 'pages.post.admin.tambah_penghuni')
    ->name('admin.tambah_penghuni');

Volt::route('/admin/lihat_penghuni_kamar/{id}', 'pages.post.admin.lihat_penghuni_kamar')
    ->name('admin.lihat_penghuni_kamar');

Volt::route('/admin/konfirmasi_bayar', 'pages.post.admin.konfirmasi_bayar')
    ->name('admin.konfirmasi_bayar');

Volt::route('/admin/histori_pembayaran', 'pages.post.admin.histori_pembayaran')
    ->name('admin.histori_pembayaran');

Volt::route('/admin/konfirmasi', 'pages.post.admin.konfirmasi')
    ->name('admin.konfirmasi');

Volt::route('/admin/daftar_pengaduan', 'pages.post.admin.daftar_pengaduan')
    ->name('admin.daftar_pengaduan');

Volt::route('/admin/pengumuman', 'pages.post.admin.pengumuman')
    ->name('admin.pengumuman');



Volt::route(
    '/landing_page',
    'pages.post.landing_page'
)->name('landing_page');
Route::redirect('/', '/landing_page');


Route::redirect('/customer', '/customer/dashboard');

Volt::route('/customer/dashboard', 'pages.post.customer.dashboard_customer')
    ->name('customer.dashboard');

Volt::route('/customer/kamar', 'pages.post.customer.kamar')
    ->name('customer.kamar');

Volt::route('/customer/pengajuan/{id}', 'pages.post.customer.pengajuan')
    ->name('customer.pengajuan');

Volt::route('/customer/booking', 'pages.post.customer.booking')
    ->name('customer.booking');

Volt::route('customer/pembayaran', 'pages.post.customer.pembayaran')
    ->name('customer.pembayaran');

Volt::route('/customer/pengaduan', 'pages.post.customer.pengaduan')
    ->name('customer.pengaduan');

Volt::route('/customer/profil', 'pages.post.customer.profil')
    ->name('customer.profil');