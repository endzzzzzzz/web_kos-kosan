<?php

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Volt\Volt;
use App\Models\Pengajuan;

new #[Layout('layouts.customer')] class extends Component
{
    public function render()
    {
        return view('pages.post.customer.booking', [
            'pengajuans' => \App\Models\Pengajuan::with('kamar.informasiKamar')
            ->where('user_id', auth()->id())
            ->latest()
            ->get()
        ]);
    }

    public function batalkan($id)
    {
        $pengajuan = Pengajuan::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if ($pengajuan) {
            $pengajuan->delete();
        }
    }
    
};

?>

<div class="min-h-screen bg-[white] p-20">

  

        <h1 class="text-3xl font-black text-[black] mb-8">
            Booking Saya
        </h1>

        @if($pengajuans->count() == 0)
            <div class="bg-white p-10 rounded-2xl shadow-lg text-center border border-slate-200">
                <p class="text-slate-500 font-semibold mb-10">
                    Belum ada booking yang kamu ajukan
                </p>
                 <a href="{{ route('customer.kamar') }}"
                class="bg-[#F58A8A] text-white px-5 py-2 rounded-xl font-semibold
                        inline-block
                        transform transition-transform duration-200
                        hover:scale-110">
                    Pesan Kamar
                </a>
            </div>
        @else
            <div class="grid gap-5">

                @foreach($pengajuans as $pengajuan)

                    <div class="bg-white  rounded-3xl p-8 shadow-lg hover:shadow-xl transition border border-slate-200">

                        <div class="flex justify-between items-center mb-4 ">
                            <h2 class="text-xl font-bold text-slate-800">
                                {{ $pengajuan->nama }}
                            </h2>

                            <span class="
                                px-3 py-1 rounded-full text-xs font-bold
                                {{ $pengajuan->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $pengajuan->status == 'approved' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $pengajuan->status == 'rejected' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $pengajuan->status == 'waiting_payment' ? 'bg-blue-100 text-blue-700' : '' }}
                            ">
                                {{ strtoupper(str_replace('_', ' ', $pengajuan->status)) }}
                            </span>
                            
                        </div>

                        <div class="text-sm text-slate-600 space-y-1">
                            <p> {{ $pengajuan->no_hp }}</p>
                            <p> {{ $pengajuan->alamat }}</p>
                            <p> Kamar: {{ $pengajuan->kamar->nomor_kamar ?? 'belum ada' }}</p>
                            <p> Tipe : {{ $pengajuan->kamar->informasiKamar->nama_kamar ?? 'belum ada' }}</p>
                        </div>
                        
                        @if($pengajuan->status != 'paid')
                        <div class="mt-5 flex justify-end">

                            <button
                                wire:click="batalkan({{ $pengajuan->id }})"
                                wire:confirm="Yakin ingin membatalkan pengajuan ini?"
                                class="px-4 py-2 bg-red-400 text-white rounded-xl font-semibold hover:bg-red-600 transition">

                                Batalkan Pengajuan

                            </button>

                        </div>
                        @endif

                    </div>

                @endforeach

            </div>
        @endif


</div>
