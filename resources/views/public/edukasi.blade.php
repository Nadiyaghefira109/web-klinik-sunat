@extends('layouts.app')

@section('title', 'Panduan Edukasi Sirkumsisi Modern - Rumah Sunat Elnara')

@section('content')
<div class="bg-gradient-to-r from-emerald-900 to-teal-800 text-white py-14">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <span class="inline-block px-3.5 py-1 bg-emerald-700/60 border border-emerald-500/40 rounded-full text-xs font-semibold text-emerald-200 uppercase tracking-wider mb-3">
            Informasi Medis Terpercaya
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Panduan Edukasi & Perawatan Khitan Modern</h1>
        <p class="mt-2 text-emerald-100 text-sm max-w-xl mx-auto">
            Bekali diri Anda dan jagoan dengan pengetahuan pra-tindakan serta kiat perawatan pasca khitan yang tepat.
        </p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 py-16 space-y-12">
    <!-- 1. Needle-free anesthesia -->
    <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-sm flex flex-col md:flex-row items-center gap-8">
        <div class="w-20 h-20 rounded-3xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-4xl shrink-0">
            <i class="bi bi-shield-check"></i>
        </div>
        <div>
            <h3 class="text-xl font-extrabold text-slate-900 mb-2">Bius Modern Tanpa Jarum Suntik (Needle-Free)</h3>
            <p class="text-sm text-slate-600 leading-relaxed">
                Kami menggunakan alat bertekanan pegas mikro (*Comfort-In*) yang mengubah cairan anestesi menjadi partikel halus berkecepatan tinggi yang meresap langsung ke pori-pori kulit. Tindakan ini sepenuhnya menghilangkan rasa sakit tusukan jarum dan membebaskan anak dari trauma fobia jarum suntik.
            </p>
        </div>
    </div>

    <!-- 2. Pra-Khitan Checklist -->
    <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-sm">
        <h3 class="text-xl font-extrabold text-slate-900 mb-6 flex items-center">
            <i class="bi bi-card-checklist text-emerald-600 mr-3"></i> Persiapan Sebelum Tindakan (Pra-Khitan)
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-slate-700">
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 flex items-start space-x-3">
                <i class="bi bi-check-circle-fill text-emerald-500 mt-1"></i>
                <span><strong>Kondisi Fisik:</strong> Pastikan anak dalam kondisi sehat, tidak demam, batuk, atau pilek berat.</span>
            </div>
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 flex items-start space-x-3">
                <i class="bi bi-check-circle-fill text-emerald-500 mt-1"></i>
                <span><strong>Makan & Minum:</strong> Anak diperbolehkan dan disarankan makan sebelum tindakan (tidak perlu puasa).</span>
            </div>
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 flex items-start space-x-3">
                <i class="bi bi-check-circle-fill text-emerald-500 mt-1"></i>
                <span><strong>Pakaian Longgar:</strong> Siapkan celana yang longgar atau sarung untuk kenyamanan pasca tindakan.</span>
            </div>
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 flex items-start space-x-3">
                <i class="bi bi-check-circle-fill text-emerald-500 mt-1"></i>
                <span><strong>Dukungan Emosional:</strong> Berikan motivasi positif bahwa khitan adalah proses menjadi jagoan mandiri.</span>
            </div>
        </div>
    </div>

    <!-- 3. Pasca-Khitan Care -->
    <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-sm">
        <h3 class="text-xl font-extrabold text-slate-900 mb-6 flex items-center">
            <i class="bi bi-heart-pulse text-emerald-600 mr-3"></i> Perawatan Pasca Khitan (Berdasarkan Metode)
        </h3>
        <div class="space-y-4 text-sm text-slate-700">
            <div class="p-5 bg-emerald-50/50 rounded-2xl border border-emerald-100">
                <h4 class="font-bold text-emerald-900 mb-1">Perawatan Metode Mahdian Klem</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Anak boleh langsung mandi dan terkena air secara normal. Setelah buang air kecil, bilas ujung klem dengan air bersih lalu keringkan perlahan dengan tisu steril. Tetap gunakan celana sunat pelindung klem. Kontrol pelepasan tabung klem dijadwalkan pada hari ke-4 hingga ke-5.
                </p>
            </div>
            <div class="p-5 bg-blue-50/50 rounded-2xl border border-blue-100">
                <h4 class="font-bold text-blue-900 mb-1">Perawatan Metode Circum Pen Super</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Luka hasil electric pen sangat presisi dan cepat kering. Hindari membasahi area luka selama 2 hari pertama. Oleskan salep antibiotik yang diresepkan dokter secara teratur 2 kali sehari.
                </p>
            </div>
            <div class="p-5 bg-amber-50/50 rounded-2xl border border-amber-100">
                <h4 class="font-bold text-amber-900 mb-1">Perawatan Metode Gun Stapler</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Staples titanium pelindung luka akan mulai tanggal/lepas dengan sendirinya secara bertahap mulai hari ke-10 hingga ke-21. Jaga area tetap kering dan gunakan silikon pelindung saat beraktivitas.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection