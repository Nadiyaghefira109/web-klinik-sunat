<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Rumah Sunat Elnara - Klinik El Medika')</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                        },
                        accent: {
                            500: '#0284c7',
                            600: '#0369a1',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-slate-50 text-slate-800 flex flex-col min-h-screen">

    <!-- Top Bar -->
    <div class="bg-emerald-800 text-emerald-100 text-xs py-2 px-4 border-b border-emerald-700/50">
        <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center gap-2">
            <div class="flex items-center space-x-4">
                <span><i class="bi bi-geo-alt-fill text-emerald-400 mr-1"></i> Bandar Lampung, Lampung</span>
                <a href="https://www.google.com/maps/search/?api=1&query=Jl.+Raden+Intan+No.+88+Bandar+Lampung" target="_blank" rel="noopener noreferrer" class="hover:text-white transition flex items-center">
                    <i class="bi bi-geo-alt-fill text-emerald-400 mr-1"></i> Bandar Lampung (Buka Maps)
                </a>
                <span><i class="bi bi-clock-fill text-emerald-400 mr-1"></i> Buka Setiap Hari: 08.00 - 20.00 WIB</span>
            </div>
            <div class="flex items-center space-x-4">
                <a href="https://wa.me/6281234567890" target="_blank" class="hover:text-white transition flex items-center">
                    <i class="bi bi-whatsapp text-emerald-400 mr-1"></i> Konsultasi WA: 0812-3456-7890
                </a>
                @auth
                <a href="{{ route('login') }}" class="font-semibold text-emerald-300 hover:text-white underline">
                    <i class="bi bi-speedometer2 mr-1"></i> Panel {{ ucfirst(Auth::user()->role) }}
                </a>
                @else
                <a href="{{ route('login') }}" class="hover:text-white transition">
                    <i class="bi bi-lock-fill mr-1"></i> Login Staf
                </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Main Navigation Sticky -->
    <nav class="sticky top-0 z-40 bg-white/95 backdrop-blur-md shadow-sm border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white shadow-lg shadow-emerald-500/20">
                        <i class="bi bi-hospital text-2xl"></i>
                    </div>
                    <div>
                        <span class="text-xl font-extrabold text-slate-900 tracking-tight block">RUMAH SUNAT ELNARA</span>
                        <span class="text-xs font-semibold text-emerald-600 tracking-wider uppercase">Klinik El Medika • Sirkumsisi Modern</span>
                    </div>
                </a>

                <!-- Desktop Nav -->
                <div class="hidden md:flex items-center space-x-1 lg:space-x-3">
                    <a href="{{ route('home') }}" class="px-3 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('home') ? 'text-emerald-600 bg-emerald-50 font-semibold' : 'text-slate-600 hover:text-emerald-600 hover:bg-slate-50' }}">Beranda</a>
                    <a href="{{ route('paket') }}" class="px-3 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('paket') ? 'text-emerald-600 bg-emerald-50 font-semibold' : 'text-slate-600 hover:text-emerald-600 hover:bg-slate-50' }}">Katalog & Biaya</a>
                    <a href="{{ route('cek_antrean') }}" class="px-3 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('cek_antrean') ? 'text-emerald-600 bg-emerald-50 font-semibold' : 'text-slate-600 hover:text-emerald-600 hover:bg-slate-50' }}">Cek Antrean</a>
                    <a href="{{ route('edukasi') }}" class="px-3 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('edukasi') ? 'text-emerald-600 bg-emerald-50 font-semibold' : 'text-slate-600 hover:text-emerald-600 hover:bg-slate-50' }}">Edukasi Khitan</a>
                    <a href="{{ route('home') }}#lokasi" class="px-3 py-2 rounded-xl text-sm font-medium text-slate-600 hover:text-emerald-600 hover:bg-slate-50">Lokasi & Maps</a>

                    <a href="{{ route('daftar') }}" class="ml-3 inline-flex items-center px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 shadow-lg shadow-emerald-600/25 transition transform hover:-translate-y-0.5">
                        <i class="bi bi-calendar-check mr-2"></i> Daftar Sunat
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center md:hidden">
                    <button id="btnMobileToggle" class="p-2 rounded-xl text-slate-600 hover:text-emerald-600 hover:bg-slate-100 focus:outline-none">
                        <i class="bi bi-list text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Nav Menu -->
        <div id="mobileMenu" class="hidden md:hidden border-t border-slate-100 bg-white px-4 pt-2 pb-4 space-y-1 shadow-lg">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-emerald-50 hover:text-emerald-600">Beranda</a>
            <a href="{{ route('paket') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-emerald-50 hover:text-emerald-600">Katalog & Biaya</a>
            <a href="{{ route('cek_antrean') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-emerald-50 hover:text-emerald-600">Cek Antrean</a>
            <a href="{{ route('edukasi') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-emerald-50 hover:text-emerald-600">Edukasi Khitan</a>
            <a href="{{ route('home') }}#lokasi" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-emerald-50 hover:text-emerald-600">Lokasi & Maps</a>
            <a href="{{ route('daftar') }}" class="block text-center px-4 py-3 rounded-xl font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow mt-2">
                <i class="bi bi-calendar-check mr-2"></i> Daftar Sunat Online
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 pt-16 pb-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-emerald-600 flex items-center justify-center text-white font-bold">
                            <i class="bi bi-hospital"></i>
                        </div>
                        <span class="text-xl font-extrabold text-white">RUMAH SUNAT ELNARA</span>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed mb-6 pr-6">
                        Pusat pelayanan sirkumsisi modern ramah anak dengan metode Mahdian Klem, Circum Pen Super, dan Gun Stapler. Menghadirkan pengalaman khitan yang nyaman, higienis, minim rasa sakit, bius tanpa jarum suntik, dan tanpa jahit.
                    </p>
                    <div class="flex space-x-3 text-lg">
                        <a href="#" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-emerald-600 flex items-center justify-center text-slate-300 hover:text-white transition"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-emerald-600 flex items-center justify-center text-slate-300 hover:text-white transition"><i class="bi bi-facebook"></i></a>
                        <a href="https://wa.me/6281234567890" target="_blank" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-emerald-600 flex items-center justify-center text-slate-300 hover:text-white transition"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>

                <div>
                    <h3 class="text-white font-bold text-base mb-4 tracking-wide uppercase text-sm">Layanan Utama</h3>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('paket', ['kategori' => 'anak']) }}" class="hover:text-emerald-400 transition">Sunat Anak Ramah Anak</a></li>
                        <li><a href="{{ route('paket', ['kategori' => 'rumah']) }}" class="hover:text-emerald-400 transition">Sunat Di Rumah (Home Care)</a></li>
                        <li><a href="{{ route('paket', ['kategori' => 'premium']) }}" class="hover:text-emerald-400 transition">Sunat Premium VIP (Gun Stapler)</a></li>
                        <li><a href="{{ route('paket', ['kategori' => 'dewasa']) }}" class="hover:text-emerald-400 transition">Sunat Dewasa (Privasi Tinggi)</a></li>
                        <li><a href="{{ route('paket', ['kategori' => 'bayi']) }}" class="hover:text-emerald-400 transition">Sunat Bayi (Baby Care)</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-bold text-base mb-4 tracking-wide uppercase text-sm">Kontak & Lokasi</h3>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li class="flex items-start">
                            <i class="bi bi-geo-alt text-emerald-400 mr-2 mt-0.5"></i>
                            <span>Jl. Raden Intan No. 88, Bandar Lampung, Lampung</span>
                            <i class="bi bi-geo-alt-fill text-emerald-400 mr-2 mt-0.5"></i>
                            <a href="https://www.google.com/maps/search/?api=1&query=Jl.+Raden+Intan+No.+88+Bandar+Lampung" target="_blank" rel="noopener noreferrer" class="hover:text-emerald-300 transition underline underline-offset-2">
                                Jl. Raden Intan No. 88, Bandar Lampung, Lampung (Petunjuk Arah Google Maps)
                            </a>
                        </li>
                        <li class="flex items-center">
                            <i class="bi bi-whatsapp text-emerald-400 mr-2"></i>
                            <span>0812-3456-7890</span>
                        </li>
                        <li class="flex items-center">
                            <i class="bi bi-envelope text-emerald-400 mr-2"></i>
                            <span>info@elnaramedika.id</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-800/80 text-center text-xs text-slate-500 flex flex-col sm:flex-row justify-between items-center gap-4">
                <p>&copy; {{ date('Y') }} Rumah Sunat Elnara (Klinik El Medika). Proyek Mandiri Politeknik Negeri Lampung.</p>
                <p class="text-slate-400">Powered by <strong class="text-emerald-400">Laravel 10</strong> & Tailwind CSS</p>
            </div>
        </div>
    </footer>

    <!-- Mobile Nav Script -->
    <script>
        const btnToggle = document.getElementById('btnMobileToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        if (btnToggle && mobileMenu) {
            btnToggle.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // Global SweetAlert notification
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#059669',
        });
        @endif

        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Perhatian!',
            text: "{{ session('error') }}",
            confirmButtonColor: '#dc2626',
        });
        @endif
    </script>
    <!-- Floating WhatsApp Button (Kiri Bawah) -->
    <div class="fixed bottom-6 left-6 z-50 flex items-center group">
        <a href="https://wa.me/6281234567890?text=Halo%20Rumah%20Sunat%20Elnara%20(Klinik%20El%20Medika),%20saya%20ingin%20konsultasi%20mengenai%20layanan%20khitan"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="Konsultasi WhatsApp"
            class="flex items-center gap-3 bg-gradient-to-r from-[#25D366] to-[#128C7E] hover:from-[#20bd5a] hover:to-[#0d7367] text-white px-3.5 py-3 sm:px-4 sm:py-3 rounded-full shadow-2xl shadow-emerald-600/40 transition-all duration-300 transform hover:-translate-y-1 hover:scale-105 border-2 border-white/20">
            <div class="relative flex items-center justify-center">
                <i class="bi bi-whatsapp text-2xl"></i>
                <span class="absolute -top-1 -right-1 flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-200"></span>
                </span>
            </div>
            <div class="hidden sm:block text-left leading-tight pr-1">
                <span class="block text-[10px] font-semibold text-emerald-100 uppercase tracking-wider">Konsultasi Gratis</span>
                <span class="block text-xs font-extrabold text-white">Chat WhatsApp</span>
            </div>
        </a>
    </div>

    @stack('scripts')
</body>

</html>