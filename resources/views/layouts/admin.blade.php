<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Sistem') - Rumah Sunat Elnara</title>

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

<body class="bg-slate-100 text-slate-800 flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col shrink-0 shadow-xl min-h-screen">
        <!-- Logo -->
        <div class="h-20 flex items-center px-6 bg-slate-950 border-b border-slate-800/80 gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white font-bold shadow-md shadow-emerald-500/30">
                <i class="bi bi-hospital"></i>
            </div>
            <div>
                <span class="font-extrabold text-white text-base tracking-tight block">ELNARA MEDIKA</span>
                <span class="text-xs text-emerald-400 font-semibold uppercase tracking-wider">
                    Panel {{ ucfirst(Auth::user()->role) }}
                </span>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-grow p-4 space-y-1.5 overflow-y-auto">
            @php $role = Auth::user()->role; @endphp

            @if($role === 'admin')
            <div class="px-3 pb-1 text-xs font-bold text-slate-500 uppercase tracking-wider">Operasional Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.dashboard*') ? 'bg-emerald-600 text-white font-semibold shadow-lg shadow-emerald-600/30' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="bi bi-speedometer2 text-lg mr-3"></i> Dashboard
            </a>
            <a href="{{ route('admin.pendaftaran') }}" class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.pendaftaran*') ? 'bg-emerald-600 text-white font-semibold shadow-lg shadow-emerald-600/30' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="bi bi-clipboard2-check text-lg mr-3"></i> Pendaftaran & DP
            </a>
            <a href="{{ route('admin.antrean') }}" class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.antrean*') ? 'bg-emerald-600 text-white font-semibold shadow-lg shadow-emerald-600/30' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="bi bi-megaphone text-lg mr-3"></i> Panggilan Antrean
            </a>

            <div class="px-3 pt-4 pb-1 text-xs font-bold text-slate-500 uppercase tracking-wider">Master Data</div>
            <a href="{{ route('admin.paket') }}" class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.paket*') ? 'bg-emerald-600 text-white font-semibold shadow-lg shadow-emerald-600/30' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="bi bi-box-seam text-lg mr-3"></i> Paket & Tarif Sunat
            </a>
            <a href="{{ route('admin.pasien') }}" class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.pasien*') ? 'bg-emerald-600 text-white font-semibold shadow-lg shadow-emerald-600/30' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="bi bi-people text-lg mr-3"></i> Data Pasien (RM)
            </a>
            <a href="{{ route('admin.dokter') }}" class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.dokter*') ? 'bg-emerald-600 text-white font-semibold shadow-lg shadow-emerald-600/30' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="bi bi-person-badge text-lg mr-3"></i> Tenaga Medis
            </a>

            <div class="px-3 pt-4 pb-1 text-xs font-bold text-slate-500 uppercase tracking-wider">Komunikasi & Finansial</div>
            <a href="{{ route('admin.kirim_wa') }}" class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.kirim_wa*') ? 'bg-emerald-600 text-white font-semibold shadow-lg shadow-emerald-600/30' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="bi bi-whatsapp text-lg mr-3"></i> WhatsApp Gateway
            </a>
            <a href="{{ route('admin.laporan') }}" class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.laporan*') ? 'bg-emerald-600 text-white font-semibold shadow-lg shadow-emerald-600/30' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="bi bi-cash-stack text-lg mr-3"></i> Laporan Keuangan
            </a>

            @elseif($role === 'dokter')
            <div class="px-3 pb-1 text-xs font-bold text-slate-500 uppercase tracking-wider">Pelayanan Medis</div>
            <a href="{{ route('dokter.dashboard') }}" class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('dokter.dashboard*') ? 'bg-emerald-600 text-white font-semibold shadow-lg shadow-emerald-600/30' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="bi bi-speedometer2 text-lg mr-3"></i> Dashboard Dokter
            </a>
            <a href="{{ route('dokter.antrean') }}" class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('dokter.antrean*') ? 'bg-emerald-600 text-white font-semibold shadow-lg shadow-emerald-600/30' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="bi bi-person-heart text-lg mr-3"></i> Antrean Tindakan
            </a>

            @elseif($role === 'pimpinan')
            <div class="px-3 pb-1 text-xs font-bold text-slate-500 uppercase tracking-wider">Eksekutif & Analitik</div>
            <a href="{{ route('pimpinan.dashboard') }}" class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('pimpinan.dashboard*') ? 'bg-emerald-600 text-white font-semibold shadow-lg shadow-emerald-600/30' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="bi bi-graph-up-arrow text-lg mr-3"></i> Executive Summary
            </a>
            <a href="{{ route('pimpinan.laporan') }}" class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('pimpinan.laporan*') ? 'bg-emerald-600 text-white font-semibold shadow-lg shadow-emerald-600/30' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="bi bi-file-earmark-bar-graph text-lg mr-3"></i> Laporan Finansial
            </a>
            @endif

            <div class="pt-4 border-t border-slate-800/80 mt-4">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-medium text-slate-400 hover:bg-slate-800 hover:text-emerald-400 transition">
                    <i class="bi bi-box-arrow-up-right text-base mr-3"></i> Buka Web Publik
                </a>
            </div>
        </nav>

        <!-- User profile in sidebar footer -->
        <div class="p-4 border-t border-slate-800/80 bg-slate-950/60 flex items-center justify-between">
            <div class="flex items-center space-x-3 overflow-hidden">
                <div class="w-9 h-9 rounded-full bg-emerald-700/60 text-emerald-300 font-bold flex items-center justify-center shrink-0">
                    {{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->nama }}</p>
                    <p class="text-xs text-slate-400 truncate">@ {{ Auth::user()->username }}</p>
                </div>
            </div>
            <a href="{{ route('logout') }}" title="Logout" class="text-slate-400 hover:text-rose-400 p-2 rounded-lg hover:bg-slate-800 transition">
                <i class="bi bi-box-arrow-right text-lg"></i>
            </a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-grow flex flex-col min-w-0">
        <!-- Top Navigation -->
        <header class="h-20 bg-white border-b border-slate-200/80 px-8 flex justify-between items-center sticky top-0 z-30 shadow-xs">
            <div>
                <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">@yield('page_title', 'Dashboard')</h1>
                <p class="text-xs text-slate-500">@yield('page_subtitle', 'Sistem Informasi Pelayanan Rumah Sunat Elnara')</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right hidden sm:block">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Waktu Sistem</span>
                    <span class="text-sm font-bold text-slate-700" id="liveClock">{{ date('d M Y, H:i') }} WIB</span>
                </div>
            </div>
        </header>

        <!-- Page Body -->
        <main class="p-8 flex-grow">
            @yield('content')
        </main>
    </div>

    <!-- Live clock and SweetAlert -->
    <script>
        function updateClock() {
            const now = new Date();
            const options = {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            const clockEl = document.getElementById('liveClock');
            if (clockEl) {
                clockEl.innerText = now.toLocaleDateString('id-ID', options) + ' WIB';
            }
        }
        setInterval(updateClock, 1000);

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
    @stack('scripts')
</body>

</html>