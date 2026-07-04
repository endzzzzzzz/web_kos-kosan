<?php

use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

new #[Layout('layouts.admin')] class extends Component
{
    public $name;
    public $email;
    public $password;

    public function mount()
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|min:6',
        ]);

        $user = Auth::user();

        $user->name = $this->name;
        $user->email = $this->email;

        if ($this->password) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        $this->password = '';

        session()->flash('success', 'Profil berhasil diperbarui');
    }

    public function render()
    {
        return view('pages.post.admin.profil');
    }
};

?>

<div class="p-6">

    <h1 class="text-2xl font-bold text-slate-800 mb-6">
        Profil Admin
    </h1>

    @if(session('success'))
        <div class="p-3 bg-green-100 text-green-700 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-3">
        <div class="bg-white p-6 rounded-3xl shadow space-y-5">
        <div>
            <label class="text-sm text-slate-600">Nama</label>
            <input type="text" wire:model="name"
                class="w-full px-4 py-2 border border-slate-200 rounded-lg">
        </div>

        <div>
            <label class="text-sm text-slate-600">Email</label>
            <input type="email" wire:model="email"
                class="w-full px-4 py-2 border border-slate-200 rounded-lg">
        </div>

        <div>
            <label class="text-sm text-slate-600">Password Baru</label>
            <input type="password" wire:model="password"
                class="w-full px-4 py-2 border border-slate-200 rounded-lg"
                placeholder="Kosongkan jika tidak diubah">
        </div>

        <div>
            <label class="text-sm text-slate-600">Konfirmasi Password</label>
            <input type="password" wire:model="password_confirmation"
                class="w-full px-4 py-2 border border-slate-200 rounded-lg"
                placeholder="Ulangi password baru">
        </div>

        <div class="flex items-center gap-3">
                <button
                    wire:click="updateProfile"
                    class="bg-[#7FD6DA] hover:bg-[#5ec8cc] text-white text-sm px-4 py-2 rounded-xl font-semibold transition">

                    Simpan
                </button>

                <a
                    href="/admin/dashboard"
                    class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2 text-sm rounded-xl font-semibold transition">

                    Batal
                </a>

            </div>
        </div>

    </div>

</div>