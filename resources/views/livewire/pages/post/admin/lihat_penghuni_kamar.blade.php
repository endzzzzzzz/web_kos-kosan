<?php
use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\Pengajuan;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.admin')] class extends Component
{
    public Kamar $kamar;

    public function mount($id)
    {
        $this->kamar = Kamar::findOrFail($id);
    }

    public function render()
    {
        $penghunis = Penghuni::where('kamar_id', $this->kamar->id)->get();

        return view('livewire.pages.post.admin.lihat_penghuni_kamar', [
            'penghunis' => $penghunis
        ]);
    }
};
?>


<div class="p-6">

    <h1 class="text-2xl font-bold text-slate-800 mb-5">
        Penghuni Kamar {{ $kamar->nomor_kamar }}
    </h1>

    @forelse ($penghunis as $p)
        @php
            $pengajuan = \App\Models\Pengajuan::where('user_id', $p->user_id)
                ->where('kamar_id', $p->kamar_id)
                ->first();
        @endphp

        <div class="bg-white border border-slate-200 shadow-lg rounded-xl p-4 mb-3 space-y-1">

            <p class="font-bold text-slate-800">
                {{ $p->nama }}
            </p>

            <p>No HP   : {{ $pengajuan->no_hp ?? '-' }}</p>
            <p>Alamat: {{ $pengajuan->alamat_asal ?? '-' }}</p>

        </div>
    @empty
        <p class="text-gray-500">Belum ada penghuni di kamar ini.</p>
    @endforelse

    <a
        href="/admin/data_kamar"
        class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2 text-sm rounded-xl font-semibold transition">

            Kembali
    </a>
</div>