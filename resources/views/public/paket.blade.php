@extends('layouts.app')

@section('title', 'Katalog Lengkap & Biaya Transparan - Rumah Sunat Elnara')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-emerald-900 to-teal-800 text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block px-3 py-1 bg-emerald-700/60 border border-emerald-500/40 rounded-full text-xs font-semibold text-emerald-200 uppercase tracking-wider mb-3">
            Transparansi Biaya & Bebas Biaya Tersembunyi
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Katalog Paket Khitan Modern & Tarif Lengkap</h1>
        <p class="mt-2 text-emerald-100 text-sm max-w-2xl mx-auto">
            Temukan pilihan paket khitan ramah anak, home care, premium VIP, dewasa, dan bayi dengan kepastian tarif serta kemudahan pembayaran uang muka (DP).
        </p>

        <!-- Filter Buttons -->
        <div class="mt-8 flex flex-wrap justify-center gap-2">
            <a href="{{ route('paket') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ !$kategori ? 'bg-amber-400 text-slate-900 shadow-md' : 'bg-white/10 hover:bg-white/20 text-white' }}">
                Semua Paket (8)
            </a>
            <a href="{{ route('paket', ['kategori' => 'anak']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $kategori === 'anak' ? 'bg-amber-400 text-slate-900 shadow-md' : 'bg-white/10 hover:bg-white/20 text-white' }}">
                Sunat Anak
            </a>
            <a href="{{ route('paket', ['kategori' => 'rumah']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $kategori === 'rumah' ? 'bg-amber-400 text-slate-900 shadow-md' : 'bg-white/10 hover:bg-white/20 text-white' }}">
                Sunat Di Rumah (Home Care)
            </a>
            <a href="{{ route('paket', ['kategori' => 'premium']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $kategori === 'premium' ? 'bg-amber-400 text-slate-900 shadow-md' : 'bg-white/10 hover:bg-white/20 text-white' }}">
                Sunat Premium VIP
            </a>
            <a href="{{ route('paket', ['kategori' => 'dewasa']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $kategori === 'dewasa' ? 'bg-amber-400 text-slate-900 shadow-md' : 'bg-white/10 hover:bg-white/20 text-white' }}">
                Sunat Dewasa
            </a>
            <a href="{{ route('paket', ['kategori' => 'bayi']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $kategori === 'bayi' ? 'bg-amber-400 text-slate-900 shadow-md' : 'bg-white/10 hover:bg-white/20 text-white' }}">
                Sunat Bayi (Baby Care)
            </a>
        </div>
    </div>
</div>

<!-- Package Grid -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($pakets as $p)
        <div class="bg-white rounded-3xl overflow-hidden border border-slate-200/90 shadow-sm hover:shadow-2xl transition duration-300 group flex flex-col justify-between">
            <div>
                <!-- Image Container with Hover Zoom -->
                <div class="h-56 overflow-hidden relative bg-slate-100">
                    <img src="{{ asset('assets/img/' . $p->gambar) }}" alt="{{ $p->nama_paket }}" class="w-full h-full object-cover group-hover:scale-106 transition duration-500">

                    <!-- Badges -->
                    <div class="absolute top-4 left-4 flex flex-col gap-1.5">
                        <span class="px-3 py-1 bg-slate-900/80 backdrop-blur-md text-white text-xs font-extrabold rounded-full uppercase tracking-wider">
                            {{ $p->kategori_layanan }}
                        </span>
                    </div>

                    <div class="absolute bottom-3 right-3">
                        <span class="px-2.5 py-1 bg-emerald-600/90 backdrop-blur-sm text-white text-xs font-bold rounded-lg shadow">
                            Metode: {{ ucwords(str_replace('_', ' ', $p->metode_sunat)) }}
                        </span>
                    </div>
                </div>

                <!-- Content Details -->
                <div class="p-6">
                    <h3 class="text-xl font-extrabold text-slate-900 mb-2 leading-snug">{{ $p->nama_paket }}</h3>
                    <p class="text-xs text-slate-500 leading-relaxed mb-4">{{ $p->deskripsi }}</p>

                    <!-- Keunggulan Points -->
                    @if($p->keunggulan)
                    <div class="mb-4 space-y-1.5">
                        <span class="text-xs font-bold text-slate-700 block uppercase tracking-wider">Keunggulan Medis:</span>
                        <ul class="text-xs text-slate-600 space-y-1">
                            @foreach(explode("\n", $p->keunggulan) as $point)
                            @if(trim($point))
                            <li class="flex items-start">
                                <i class="bi bi-check2-circle text-emerald-500 mr-1.5 shrink-0 mt-0.5"></i>
                                <span>{{ trim($point) }}</span>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Fasilitas Include -->
                    @if($p->fasilitas_include)
                    <div class="mb-4 p-3 bg-slate-50 rounded-2xl border border-slate-100 text-xs text-slate-600">
                        <span class="font-bold text-slate-800 block mb-1">Fasilitas Termasuk:</span>
                        <p class="leading-relaxed">{{ $p->fasilitas_include }}</p>
                    </div>
                    @endif

                    <!-- Financial Breakdown Box -->
                    <div class="p-4 bg-emerald-50/80 rounded-2xl border border-emerald-100 space-y-2 mt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-medium text-slate-600">Total Tarif Resmi</span>
                            <span class="text-lg font-extrabold text-emerald-700">{{ $p->harga_format }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-2 border-t border-emerald-200/60">
                            <span class="text-xs font-semibold text-slate-700 flex items-center">
                                <i class="bi bi-wallet2 text-emerald-600 mr-1.5"></i> Wajib DP (Kunci Jadwal)
                            </span>
                            <span class="text-sm font-extrabold text-amber-600">{{ $p->nominal_dp_format }}</span>
                        </div>
                        <div class="flex justify-between items-center text-xs text-slate-500">
                            <span>Sisa Pelunasan di Klinik</span>
                            <span class="font-bold text-slate-700">Rp {{ number_format($p->harga - $p->nominal_dp, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Button -->
            <div class="p-6 pt-0">
                <a href="{{ route('daftar', ['paket' => $p->id]) }}" class="block w-full py-3.5 text-center font-bold text-sm text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 rounded-xl shadow-lg shadow-emerald-600/20 transition transform hover:-translate-y-0.5">
                    <i class="bi bi-calendar-plus mr-1.5"></i> Pilih & Daftar Paket Ini
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-12 bg-white rounded-3xl border border-slate-200">
            <i class="bi bi-box-seam text-4xl text-slate-400 mb-2 block"></i>
            <p class="text-slate-500 text-sm">Tidak ada paket sunat dalam kategori ini.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection