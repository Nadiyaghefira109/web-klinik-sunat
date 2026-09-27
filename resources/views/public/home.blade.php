@extends('layouts.app')

@section('title', 'Rumah Sunat Elnara - Pelayanan Sirkumsisi Modern Ramah Anak')

@section('content')
<!-- Hero Image Slider Section -->
<section id="heroSlider" class="relative overflow-hidden min-h-[580px] lg:min-h-[640px] flex items-center text-white pt-12 pb-20 group">

    <!-- Slides Background Container -->
    <div class="absolute inset-0 z-0">
        <!-- Slide 0 (Mahdian Klem) -->
        <div class="hero-slide absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-100" data-slide="0">
            <img src="{{ asset('assets/img/mahdian_klem.jpg') }}" alt="Rumah Sunat Elnara - Mahdian Klem" class="w-full h-full object-cover object-center transform scale-105 transition-transform duration-[7000ms] ease-out">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/95 via-emerald-950/85 to-slate-950/65"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-transparent to-black/40"></div>
        </div>

        <!-- Slide 1 (Circum Pen) -->
        <div class="hero-slide absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0 pointer-events-none" data-slide="1">
            <img src="{{ asset('assets/img/circum_pen.jpg') }}" alt="Rumah Sunat Elnara - Circum Pen" class="w-full h-full object-cover object-center transform scale-105 transition-transform duration-[7000ms] ease-out">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/95 via-slate-900/85 to-emerald-950/65"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-transparent to-black/40"></div>
        </div>

        <!-- Slide 2 (Gun Stapler) -->
        <div class="hero-slide absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0 pointer-events-none" data-slide="2">
            <img src="{{ asset('assets/img/gun_stapler.jpg') }}" alt="Rumah Sunat Elnara - Gun Stapler" class="w-full h-full object-cover object-center transform scale-105 transition-transform duration-[7000ms] ease-out">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/95 via-teal-950/85 to-slate-950/65"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-transparent to-black/40"></div>
        </div>

        <!-- Slide 3 (Home Care) -->
        <div class="hero-slide absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0 pointer-events-none" data-slide="3">
            <img src="{{ asset('assets/img/home_care_klem.jpg') }}" alt="Rumah Sunat Elnara - Home Care" class="w-full h-full object-cover object-center transform scale-105 transition-transform duration-[7000ms] ease-out">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/95 via-emerald-950/85 to-slate-950/65"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-transparent to-black/40"></div>
        </div>
    </div>

    <!-- Background Grid Pattern -->
    <div class="absolute inset-0 z-1 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>

    <!-- Slide Content Overlay -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

            <!-- Left Column: Dynamic Slide Content -->
            <div class="lg:col-span-7 space-y-6">

                <!-- Text Slide 0 (Teks Utama yang Diminta) -->
                <div class="slide-text transition-all duration-700 opacity-100" data-text-slide="0">
                    <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-emerald-700/70 border border-emerald-400/40 text-emerald-200 text-xs font-semibold tracking-wide uppercase mb-4 shadow-sm backdrop-blur-md">
                        <i class="bi bi-shield-check mr-1.5 text-emerald-400"></i> Pelayanan Sirkumsisi Medis Modern No. 1 di Lampung
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight mb-4 drop-shadow-md">
                        Khitan Nyaman, Ramah Anak & <span class="text-emerald-300">Bebas Trauma Jarum</span>
                    </h1>
                    <p class="text-emerald-100 text-base sm:text-lg leading-relaxed max-w-2xl font-normal drop-shadow-sm">
                        Klinik El Medika menghadirkan inovasi sirkumsisi modern dengan metode <strong>Mahdian Klem</strong>, <strong>Circum Pen Super</strong>, dan <strong>Gun Stapler</strong>. Ditangani langsung oleh dokter berpengalaman dengan teknologi bius tanpa jarum suntik (*free-needle anesthesia*).
                    </p>
                </div>

                <!-- Text Slide 1 -->
                <div class="slide-text hidden transition-all duration-700 opacity-0" data-text-slide="1">
                    <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-blue-700/70 border border-blue-400/40 text-blue-200 text-xs font-semibold tracking-wide uppercase mb-4 shadow-sm backdrop-blur-md">
                        <i class="bi bi-pen mr-1.5 text-blue-400"></i> Inovasi Medis Tanpa Jahitan & Bebas Perban
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight mb-4 drop-shadow-md">
                        Presisi Bedah Tinggi & <span class="text-blue-300">Langsung Boleh Mandi</span>
                    </h1>
                    <p class="text-blue-100 text-base sm:text-lg leading-relaxed max-w-2xl font-normal drop-shadow-sm">
                        Teknologi <strong>Circum Pen Super</strong> elektrik micro-cauter mengunci pembuluh darah halus seketika. Hasil sangat rapi, simetris, perdarahan minimal, serta sang jagoan bebas bergerak ceria.
                    </p>
                </div>

                <!-- Text Slide 2 -->
                <div class="slide-text hidden transition-all duration-700 opacity-0" data-text-slide="2">
                    <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-amber-700/70 border border-amber-400/40 text-amber-200 text-xs font-semibold tracking-wide uppercase mb-4 shadow-sm backdrop-blur-md">
                        <i class="bi bi-gem mr-1.5 text-amber-400"></i> Khitan Standar Emas VIP & Pria Dewasa
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight mb-4 drop-shadow-md">
                        Metode Gun Stapler & <span class="text-amber-300">Privasi Medis Terjaga</span>
                    </h1>
                    <p class="text-amber-100 text-base sm:text-lg leading-relaxed max-w-2xl font-normal drop-shadow-sm">
                        Alat sirkumsisi anastomosis sekali pakai (disposable) dengan pengerjaan kilat 3–5 menit. Staples titanium pelindung lepas sendiri alami dengan hasil estetika terbaik.
                    </p>
                </div>

                <!-- Text Slide 3 -->
                <div class="slide-text hidden transition-all duration-700 opacity-0" data-text-slide="3">
                    <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-teal-700/70 border border-teal-400/40 text-teal-200 text-xs font-semibold tracking-wide uppercase mb-4 shadow-sm backdrop-blur-md">
                        <i class="bi bi-house-heart mr-1.5 text-teal-400"></i> Layanan Khusus Kunjungan Ke Rumah
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight mb-4 drop-shadow-md">
                        Sunat Di Rumah (Home Care) <span class="text-teal-300">Bersama Keluarga</span>
                    </h1>
                    <p class="text-teal-100 text-base sm:text-lg leading-relaxed max-w-2xl font-normal drop-shadow-sm">
                        Tim dokter dan perawat berpengalaman datang langsung ke kediaman Anda dengan peralatan bedah steril standar rumah sakit. Solusi ramah anak dan bebas repot bagi keluarga.
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="pt-2 flex flex-wrap gap-4 items-center">
                    <a href="{{ route('daftar') }}" class="inline-flex items-center justify-center px-7 py-4 rounded-2xl font-bold text-slate-900 bg-gradient-to-r from-amber-400 to-amber-300 hover:from-amber-300 hover:to-amber-200 shadow-xl shadow-amber-500/25 text-base transition transform hover:-translate-y-0.5">
                        <i class="bi bi-calendar-check-fill mr-2.5 text-slate-900"></i> Daftar Online Sekarang
                    </a>
                    <a href="{{ route('paket') }}" class="inline-flex items-center justify-center px-7 py-4 rounded-2xl font-semibold text-white bg-white/15 hover:bg-white/25 border border-white/30 backdrop-blur-md transition">
                        <i class="bi bi-tag mr-2 text-emerald-300"></i> Lihat Pilihan Paket & Biaya
                    </a>
                </div>

                <!-- Trust Stats -->
                <div class="grid grid-cols-3 gap-6 pt-6 border-t border-white/20 max-w-lg">
                    <div>
                        <span class="text-3xl font-extrabold text-white block">{{ $totalPasien }}+</span>
                        <span class="text-xs text-emerald-200 font-medium">Jagoan Dikhitan</span>
                    </div>
                    <div>
                        <span class="text-3xl font-extrabold text-white block">3</span>
                        <span class="text-xs text-emerald-200 font-medium">Metode Modern</span>
                    </div>
                    <div>
                        <span class="text-3xl font-extrabold text-white block">100%</span>
                        <span class="text-xs text-emerald-200 font-medium">Alat Steril & Berizin</span>
                    </div>
                </div>
            </div>

            <!-- Right Column: Glassmorphism Keunggulan Card -->
            <div class="lg:col-span-5 relative">
                <div class="relative mx-auto max-w-md bg-slate-900/60 backdrop-blur-xl border border-white/25 rounded-3xl p-6 shadow-2xl space-y-4">
                    <div class="flex items-center space-x-4 pb-4 border-b border-white/15">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-500/90 flex items-center justify-center text-white text-3xl shadow-lg shadow-emerald-500/30">
                            <i class="bi bi-patch-check-fill"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white">Keunggulan Layanan</h3>
                            <p class="text-xs text-emerald-200">Kenyamanan Pasien adalah Prioritas Utama</p>
                        </div>
                    </div>

                    <ul class="space-y-3 text-sm text-emerald-50">
                        <li class="flex items-center space-x-3">
                            <span class="w-6 h-6 rounded-full bg-emerald-500/30 text-emerald-300 flex items-center justify-center text-xs shrink-0"><i class="bi bi-check"></i></span>
                            <span>Bius Modern Tanpa Jarum Suntik (Ramah Anak)</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <span class="w-6 h-6 rounded-full bg-emerald-500/30 text-emerald-300 flex items-center justify-center text-xs shrink-0"><i class="bi bi-check"></i></span>
                            <span>Tanpa Jahit, Tanpa Perban & Langsung Boleh Mandi</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <span class="w-6 h-6 rounded-full bg-emerald-500/30 text-emerald-300 flex items-center justify-center text-xs shrink-0"><i class="bi bi-check"></i></span>
                            <span>Layanan Home Care (Tim Medis Datang ke Rumah)</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <span class="w-6 h-6 rounded-full bg-emerald-500/30 text-emerald-300 flex items-center justify-center text-xs shrink-0"><i class="bi bi-check"></i></span>
                            <span>Free Souvenir Jagoan, Celana Sunat & Obat Lengkap</span>
                        </li>
                    </ul>

                    <div class="pt-2">
                        <a href="{{ route('cek_antrean') }}" class="block w-full py-3 text-center bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl transition shadow-lg shadow-emerald-500/30">
                            <i class="bi bi-search mr-1.5"></i> Cek Antrean Online Hari Ini
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subtle Slide Dots Indicator -->
        <div class="mt-8 flex items-center justify-center sm:justify-start space-x-2 max-w-7xl mx-auto pt-2">
            <button type="button" class="slide-dot w-7 h-2 rounded-full bg-emerald-400 transition-all duration-500" onclick="goToSlide(0)" aria-label="Slide 1"></button>
            <button type="button" class="slide-dot w-2 h-2 rounded-full bg-white/30 hover:bg-white/60 transition-all duration-500" onclick="goToSlide(1)" aria-label="Slide 2"></button>
            <button type="button" class="slide-dot w-2 h-2 rounded-full bg-white/30 hover:bg-white/60 transition-all duration-500" onclick="goToSlide(2)" aria-label="Slide 3"></button>
            <button type="button" class="slide-dot w-2 h-2 rounded-full bg-white/30 hover:bg-white/60 transition-all duration-500" onclick="goToSlide(3)" aria-label="Slide 4"></button>
        </div>
    </div>
</section>

<!-- 3 Metode Unggulan Modern -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-emerald-600 font-bold text-xs uppercase tracking-wider bg-emerald-50 px-4 py-1.5 rounded-full inline-block mb-3">Teknologi Medis Terkini</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">3 Pilihan Metode Khitan Modern Unggulan</h2>
            <p class="mt-3 text-slate-500 text-base">Kami menyediakan ragam metode mutakhir berlisensi Kemenkes RI yang disesuaikan dengan kebutuhan usia dan kenyamanan jagoan Anda.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Mahdian Klem -->
            <div class="bg-slate-50 rounded-3xl p-8 border border-slate-200/80 hover:shadow-xl hover:border-emerald-500 transition group flex flex-col justify-between">
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl font-bold mb-6 group-hover:bg-emerald-600 group-hover:text-white transition">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Mahdian Klem (Disposable)</h3>
                    <p class="text-sm text-slate-500 leading-relaxed mb-4">
                        Inovasi klem sekali pakai anak bangsa. Tabung pelindung anatomis melindungi gland penis secara sempurna, proses khitan 5–7 menit.
                    </p>
                    <ul class="space-y-2 text-xs text-slate-600 font-medium mb-6">
                        <li class="flex items-center"><i class="bi bi-check-circle-fill text-emerald-500 mr-2"></i> Langsung boleh kena air & mandi</li>
                        <li class="flex items-center"><i class="bi bi-check-circle-fill text-emerald-500 mr-2"></i> Tanpa jahit & tanpa perban</li>
                        <li class="flex items-center"><i class="bi bi-check-circle-fill text-emerald-500 mr-2"></i> Cocok untuk anak aktif & bayi</li>
                    </ul>
                </div>
                <a href="{{ route('paket', ['kategori' => 'anak']) }}" class="text-emerald-600 font-bold text-sm hover:text-emerald-700 flex items-center">
                    Lihat Paket Klem <i class="bi bi-arrow-right ml-2"></i>
                </a>
            </div>

            <!-- Circum Pen Super -->
            <div class="bg-slate-50 rounded-3xl p-8 border border-slate-200/80 hover:shadow-xl hover:border-emerald-500 transition group flex flex-col justify-between">
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-2xl font-bold mb-6 group-hover:bg-blue-600 group-hover:text-white transition">
                        <i class="bi bi-pen"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Circum Pen Super</h3>
                    <p class="text-sm text-slate-500 leading-relaxed mb-4">
                        Teknologi electric pen micro-cauter berujung presisi tinggi. Memotong sekaligus membekukan pembuluh darah halus seketika (*heat-sealer*).
                    </p>
                    <ul class="space-y-2 text-xs text-slate-600 font-medium mb-6">
                        <li class="flex items-center"><i class="bi bi-check-circle-fill text-blue-500 mr-2"></i> Hasil potongan sangat simetris & estetik</li>
                        <li class="flex items-center"><i class="bi bi-check-circle-fill text-blue-500 mr-2"></i> Perdarahan sangat minim / nol</li>
                        <li class="flex items-center"><i class="bi bi-check-circle-fill text-blue-500 mr-2"></i> Pilihan favorit anak & dewasa</li>
                    </ul>
                </div>
                <a href="{{ route('paket') }}" class="text-blue-600 font-bold text-sm hover:text-blue-700 flex items-center">
                    Lihat Paket Pen <i class="bi bi-arrow-right ml-2"></i>
                </a>
            </div>

            <!-- Gun Stapler -->
            <div class="bg-slate-50 rounded-3xl p-8 border border-slate-200/80 hover:shadow-xl hover:border-emerald-500 transition group flex flex-col justify-between">
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-2xl font-bold mb-6 group-hover:bg-amber-600 group-hover:text-white transition">
                        <i class="bi bi-gem"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Gun Stapler VIP</h3>
                    <p class="text-sm text-slate-500 leading-relaxed mb-4">
                        Alat bedah sirkumsisi anastomosis berbentuk pistol bedah sekali pakai. Memotong dan memasang staples pelindung luka titanium dalam 1 tembakan.
                    </p>
                    <ul class="space-y-2 text-xs text-slate-600 font-medium mb-6">
                        <li class="flex items-center"><i class="bi bi-check-circle-fill text-amber-500 mr-2"></i> Pengerjaan kilat 3-5 menit saja</li>
                        <li class="flex items-center"><i class="bi bi-check-circle-fill text-amber-500 mr-2"></i> Staples lepas sendiri secara alami</li>
                        <li class="flex items-center"><i class="bi bi-check-circle-fill text-amber-500 mr-2"></i> Standar emas khitan pria dewasa & VIP</li>
                    </ul>
                </div>
                <a href="{{ route('paket', ['kategori' => 'premium']) }}" class="text-amber-600 font-bold text-sm hover:text-amber-700 flex items-center">
                    Lihat Paket Stapler <i class="bi bi-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Preview Katalog Paket -->
<section class="py-20 bg-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4">
            <div>
                <span class="text-emerald-600 font-bold text-xs uppercase tracking-wider bg-emerald-50 px-4 py-1.5 rounded-full inline-block mb-3">Transparansi Biaya & DP</span>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Katalog Paket Sirkumsisi Terpopuler</h2>
                <p class="text-slate-500 text-sm mt-1">Biaya transparan tanpa biaya tersembunyi dengan kemudahan sistem DP untuk mengunci jadwal.</p>
            </div>
            <a href="{{ route('paket') }}" class="px-6 py-3 bg-white border border-slate-300 rounded-xl font-bold text-sm text-slate-700 hover:text-emerald-600 hover:border-emerald-500 transition shrink-0">
                Lihat Seluruh 8 Paket <i class="bi bi-arrow-right ml-1"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($pakets->take(3) as $pkt)
            <div class="bg-white rounded-3xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-xl transition group flex flex-col justify-between">
                <div>
                    <div class="h-48 overflow-hidden relative">
                        <img src="{{ asset('assets/img/' . $pkt->gambar) }}" alt="{{ $pkt->nama_paket }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <span class="absolute top-4 left-4 px-3 py-1 bg-slate-900/80 backdrop-blur-sm text-white text-xs font-bold rounded-full uppercase">
                            {{ $pkt->kategori_layanan }}
                        </span>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-extrabold text-slate-900 mb-2">{{ $pkt->nama_paket }}</h3>
                        <p class="text-xs text-slate-500 line-clamp-2 mb-4">{{ $pkt->deskripsi }}</p>

                        <div class="p-3.5 bg-emerald-50/70 rounded-2xl mb-4 border border-emerald-100 flex justify-between items-center">
                            <div>
                                <span class="text-xs text-slate-500 block">Total Biaya</span>
                                <span class="text-base font-extrabold text-emerald-700">{{ $pkt->harga_format }}</span>
                            </div>
                            <div class="text-right">
                                <span class="text-xs text-slate-500 block">Uang Muka (DP)</span>
                                <span class="text-sm font-bold text-slate-700">{{ $pkt->nominal_dp_format }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-0">
                    <a href="{{ route('daftar', ['paket' => $pkt->id]) }}" class="block w-full text-center py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-sm shadow transition">
                        Pilih & Reservasi Jadwal
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Dokter Bertugas -->
<section class="py-20 bg-white border-t border-slate-200/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-emerald-600 font-bold text-xs uppercase tracking-wider bg-emerald-50 px-4 py-1.5 rounded-full inline-block mb-3">Tenaga Medis Profesional</span>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Dokter & Praktisi Sirkumsisi Bersertifikat</h2>
            <p class="mt-2 text-slate-500 text-sm">Didukung oleh tim dokter dan perawat berpengalaman dengan sertifikasi sirkumsisi modern ramah anak.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            @foreach($dokters as $dok)
            <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200/80 flex items-center space-x-5">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center text-4xl shrink-0 shadow-md">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase {{ $dok->status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                        {{ $dok->status === 'aktif' ? 'Praktik Aktif' : 'Cuti' }}
                    </span>
                    <h3 class="text-lg font-extrabold text-slate-900 mt-1.5">{{ $dok->nama_dokter }}</h3>
                    <p class="text-xs text-emerald-600 font-semibold mb-1">{{ $dok->spesialisasi }}</p>
                    <p class="text-xs text-slate-500"><i class="bi bi-clock mr-1"></i> {{ $dok->hari_praktik }} ({{ $dok->jam_praktik }})</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Lokasi & Peta Google Maps -->
<section id="lokasi" class="py-20 bg-slate-50 border-t border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-emerald-600 font-bold text-xs uppercase tracking-wider bg-emerald-100/80 px-4 py-1.5 rounded-full inline-block mb-3">
                <i class="bi bi-geo-alt-fill mr-1 text-emerald-500"></i> Akses Strategis & Nyaman
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Lokasi Klinik & Petunjuk Arah</h2>
            <p class="mt-2 text-slate-500 text-sm sm:text-base">Kunjungi Rumah Sunat Elnara (Klinik El Medika) di pusat kota Bandar Lampung. Didukung area parkir luas dan fasilitas ramah anak.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
            <!-- Informasi Kontak & Alamat -->
            <div class="lg:col-span-5 bg-white rounded-3xl p-8 border border-slate-200/80 shadow-lg flex flex-col justify-between space-y-6">
                <div class="space-y-6">
                    <div class="flex items-center space-x-4 pb-5 border-b border-slate-100">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center text-3xl shadow-lg shadow-emerald-500/20">
                            <i class="bi bi-hospital"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-slate-900">RUMAH SUNAT ELNARA</h3>
                            <p class="text-xs font-semibold text-emerald-600">Klinik El Medika • Sirkumsisi Modern</p>
                        </div>
                    </div>

                    <!-- Item Alamat -->
                    <div class="flex items-start space-x-3.5">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg shrink-0 mt-0.5">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Alamat Klinik</h4>
                            <p class="text-sm font-semibold text-slate-800 leading-snug mt-0.5">Jl. Raden Intan No. 88, Enggal, Kota Bandar Lampung, Lampung 35118</p>
                            <span class="text-xs text-slate-500 block mt-1"><i class="bi bi-info-circle mr-1 text-emerald-500"></i> Dekat Tugu Adipura, seberang pusat perbelanjaan</span>
                        </div>
                    </div>

                    <!-- Item Jam Buka -->
                    <div class="flex items-start space-x-3.5">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg shrink-0 mt-0.5">
                            <i class="bi bi-clock-fill"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Jam Operasional</h4>
                            <p class="text-sm font-bold text-slate-800 mt-0.5">Buka Setiap Hari: 08.00 – 20.00 WIB</p>
                            <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-700">
                                Termasuk Hari Minggu & Hari Libur Nasional
                            </span>
                        </div>
                    </div>

                    <!-- Item Telepon/WA -->
                    <div class="flex items-start space-x-3.5">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg shrink-0 mt-0.5">
                            <i class="bi bi-whatsapp"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kontak & WhatsApp</h4>
                            <p class="text-sm font-bold text-slate-800 mt-0.5">0812-3456-7890</p>
                            <span class="text-xs text-slate-500">Layanan Konsultasi Khitan 24 Jam</span>
                        </div>
                    </div>

                    <!-- Fasilitas Klinik -->
                    <div class="pt-4 border-t border-slate-100">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2.5">Fasilitas Lengkap</h4>
                        <div class="grid grid-cols-2 gap-2 text-xs text-slate-600">
                            <div class="flex items-center"><i class="bi bi-check-circle-fill text-emerald-500 mr-1.5"></i> Ruang Tindakan AC</div>
                            <div class="flex items-center"><i class="bi bi-check-circle-fill text-emerald-500 mr-1.5"></i> Parkir Luas & Aman</div>
                            <div class="flex items-center"><i class="bi bi-check-circle-fill text-emerald-500 mr-1.5"></i> Playground Anak</div>
                            <div class="flex items-center"><i class="bi bi-check-circle-fill text-emerald-500 mr-1.5"></i> Wi-Fi Cepat Gratis</div>
                        </div>
                    </div>
                </div>

                <!-- Action Button ke Google Maps -->
                <div class="pt-4 space-y-2.5">
                    <a href="https://www.google.com/maps/search/?api=1&query=Jl.+Raden+Intan+No.+88+Bandar+Lampung" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="w-full inline-flex items-center justify-center px-6 py-3.5 rounded-xl font-extrabold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 shadow-lg shadow-emerald-600/25 transition transform hover:-translate-y-0.5 text-sm">
                        <i class="bi bi-geo-alt-fill mr-2 text-lg"></i> Buka Rute di Google Maps
                    </a>
                    <a href="https://wa.me/6281234567890?text=Halo%20Rumah%20Sunat%20Elnara,%20saya%20ingin%20tanya%20patokan%20rute%20lokasi%20klinik" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="w-full inline-flex items-center justify-center px-6 py-3 rounded-xl font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition text-sm">
                        <i class="bi bi-whatsapp mr-2 text-emerald-600"></i> Panduan Rute via WhatsApp
                    </a>
                </div>
            </div>

            <!-- Google Maps Embed Container -->
            <div class="lg:col-span-7 bg-white rounded-3xl p-3 border border-slate-200/80 shadow-lg overflow-hidden flex flex-col min-h-[440px] relative group">
                <div class="relative w-full h-full min-h-[400px] rounded-2xl overflow-hidden flex-grow border border-slate-200">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.188258387063!2d105.25732157454238!3d-5.38827725389658!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e40db01799a4e25%3A0xe54e60ea9b24479f!2sJl.%20Raden%20Intan%2C%20Kota%20Bandar%20Lampung%2C%20Lampung!5e0!3m2!1sid!2sid!4v1711111111111!5m2!1sid!2sid" 
                        width="100%" 
                        height="100%" 
                        style="border:0; min-height: 420px;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                        class="w-full h-full object-cover">
                    </iframe>

                    <!-- Floating Maps Badge -->
                    <div class="absolute top-4 right-4 z-10">
                        <a href="https://www.google.com/maps/search/?api=1&query=Jl.+Raden+Intan+No.+88+Bandar+Lampung" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           class="inline-flex items-center px-4 py-2 rounded-xl bg-white/95 backdrop-blur-md shadow-lg border border-slate-200 text-xs font-bold text-slate-800 hover:text-emerald-600 transition">
                            <i class="bi bi-box-arrow-up-right mr-1.5 text-emerald-500"></i> Buka Google Maps
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Banner -->
<section class="py-16 bg-gradient-to-r from-emerald-700 to-teal-800 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">
        <h2 class="text-3xl sm:text-4xl font-extrabold">Siapkan Khitan Jagoan Anda dengan Nyaman Hari Ini</h2>
        <p class="max-w-2xl mx-auto text-emerald-100 text-sm sm:text-base">
            Daftar online mandiri tanpa perlu antre fisik di klinik. Pilih dokter, pilih metode khitan modern, dan kunci jadwal dengan sistem pembayaran DP yang aman.
        </p>
        <div class="pt-2">
            <a href="{{ route('daftar') }}" class="inline-flex items-center px-8 py-4 rounded-2xl font-extrabold text-slate-900 bg-amber-400 hover:bg-amber-300 shadow-2xl transition transform hover:scale-105">
                <i class="bi bi-calendar2-check-fill mr-2 text-slate-900"></i> Reservasi Jadwal Sunat Online
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    let currentSlide = 0;
    const totalSlides = 4;
    const SLIDE_INTERVAL = 4500; // 4.5 detik per slide (lembut dan alami)
    let autoSlideTimer = null;

    function showSlide(index) {
        currentSlide = (index + totalSlides) % totalSlides;

        // 1. Update background slide images with gentle crossfade
        document.querySelectorAll('.hero-slide').forEach((slide, idx) => {
            if (idx === currentSlide) {
                slide.classList.remove('opacity-0', 'pointer-events-none');
                slide.classList.add('opacity-100');
            } else {
                slide.classList.remove('opacity-100');
                slide.classList.add('opacity-0', 'pointer-events-none');
            }
        });

        // 2. Update dynamic slide text
        document.querySelectorAll('.slide-text').forEach((textEl, idx) => {
            if (idx === currentSlide) {
                textEl.classList.remove('hidden');
                setTimeout(() => {
                    textEl.classList.remove('opacity-0');
                    textEl.classList.add('opacity-100');
                }, 40);
            } else {
                textEl.classList.add('hidden', 'opacity-0');
                textEl.classList.remove('opacity-100');
            }
        });

        // 3. Update minimal indicator dots
        document.querySelectorAll('.slide-dot').forEach((dot, idx) => {
            if (idx === currentSlide) {
                dot.classList.remove('w-2', 'bg-white/30');
                dot.classList.add('w-7', 'bg-emerald-400');
            } else {
                dot.classList.remove('w-7', 'bg-emerald-400');
                dot.classList.add('w-2', 'bg-white/30');
            }
        });
    }

    function startAutoSlide() {
        if (autoSlideTimer) clearInterval(autoSlideTimer);
        autoSlideTimer = setInterval(() => {
            showSlide(currentSlide + 1);
        }, SLIDE_INTERVAL);
    }

    function goToSlide(index) {
        showSlide(index);
        startAutoSlide(); // reset timer setelah klik dot
    }

    // Jalankan auto-slide otomatis sejak awal secara mulus
    document.addEventListener('DOMContentLoaded', () => {
        startAutoSlide();

        const sliderEl = document.getElementById('heroSlider');
        if (sliderEl) {
            // Touch swipe gesture untuk smartphone / tablet
            let touchStartX = 0;
            let touchEndX = 0;
            sliderEl.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
            }, {
                passive: true
            });

            sliderEl.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                if (touchStartX - touchEndX > 50) {
                    showSlide(currentSlide + 1);
                    startAutoSlide();
                } else if (touchEndX - touchStartX > 50) {
                    showSlide(currentSlide - 1);
                    startAutoSlide();
                }
            }, {
                passive: true
            });
        }
    });
</script>
@endpush