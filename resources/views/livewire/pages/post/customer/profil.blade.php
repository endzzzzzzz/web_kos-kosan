<?php

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Pengajuan;

new #[Layout('layouts.customer')] class extends Component {

    // USERS TABLE
    public $name;
    public $email;
    public $password;

    // PENGAJUAN TABLE
    public $nama;
    public $no_hp;
    public $alamat_asal;

    public $pengajuan;
    public $hasPaid = false;

    public function mount()
    {
        $user = auth()->user();

        // USERS
        $this->name = $user->name;
        $this->email = $user->email;

        // PENGAJUAN PAID
        $this->pengajuan = Pengajuan::where('user_id', $user->id)
            ->where('status', 'paid')
            ->first();

        if ($this->pengajuan) {
            $this->hasPaid = true;

            $this->nama = $this->pengajuan->nama;
            $this->no_hp = $this->pengajuan->no_hp;
            $this->alamat_asal = $this->pengajuan->alamat_asal;
        }
    }

    public function update()
    {
        $user = auth()->user();

        // USERS VALIDATION
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        if ($this->password) {
            $user->update([
                'password' => bcrypt($this->password),
            ]);
        }

        // PENGAJUAN UPDATE
        if ($this->hasPaid) {

            $this->validate([
                'nama' => 'required|string',
                'no_hp' => 'required',
                'alamat_asal' => 'required',
            ]);

            $this->pengajuan->update([
                'nama' => $this->nama,
                'no_hp' => $this->no_hp,
                'alamat_asal' => $this->alamat_asal,
            ]);
        }

        session()->flash('success', 'Profil berhasil diperbarui');
    }

    public function render()
    {
        return view('pages.post.customer.profil');
    }
};
?>

<div class="min-h-screen bg-[white] py-10 px-4">

    <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-lg p-6 mb-20 border border-slate-200">

        <h1 class="text-2xl font-bold text-slate-800 mb-6">
            Edit Profil
        </h1>

        @if (session()->has('success'))
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded-xl text-sm mb-5">
                {{ session('success') }}
            </div>
        @endif

        <!-- GRID -->
        <div class="grid md:grid-cols-2 gap-10">

            <!-- KIRI -->
            <div class="space-y-4">

                <h2 class="font-semibold text-slate-700">Akun</h2>

                <div>
                    <label>Nama</label>
                    <input wire:model="name"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3">
                </div>

                <div>
                    <label>Email</label>
                    <input wire:model="email"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3">
                </div>

                <div>
                    <label>Password Baru</label>
                    <input type="password"
                        wire:model="password"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3">
                </div>

                <div>
                    <label>Konfirmasi Password</label>
                    <input type="password"
                        wire:model="password_confirmation"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3">
                </div>

            </div>

            <!-- KANAN -->
            <div class="space-y-4">

                <h2 class="font-semibold text-slate-700">Identitas</h2>

                @if($hasPaid)

                    <div>
                        <label>Nama Lengkap</label>
                        <input wire:model="nama"
                            class="w-full border border-slate-200 rounded-xl px-4 py-3">
                    </div>

                    <div>
                        <label>No HP</label>
                        <input wire:model="no_hp"
                            class="w-full border border-slate-200 rounded-xl px-4 py-3">
                    </div>

                    <div>
                        <label>Alamat Asal</label>
                        <input wire:model="alamat_asal"
                            class="w-full border border-slate-200 rounded-xl px-4 py-3">
                    </div>

                @else
                    <p class="text-sm text-slate-500">
                        Data identitas tersedia setelah status paid.
                    </p>
                @endif

            </div>

        </div>

        <!-- BUTTON -->
        <div class="mt-6 flex gap-2">

            <button
                wire:click="update"
                class="bg-cyan-500 hover:bg-cyan-600 text-white py-2 px-5 rounded-lg text-sm font-semibold transition">

                Simpan
            </button>

            <a href="/"
                class="bg-slate-200 hover:bg-slate-300 text-slate-700 py-2 px-5 rounded-lg text-sm font-semibold transition">

                Batal
            </a>

        </div>
    </div>

</div>