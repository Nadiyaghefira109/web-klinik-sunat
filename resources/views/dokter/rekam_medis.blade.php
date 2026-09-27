@extends('layouts.admin')

@section('title', 'Rekam Medis Elektronik - ' . $pendaftaran->pasien->nama_pasien)
@section('page_title', 'Form Rekam Medis Elektronik (RME)')
@section('page_subtitle', 'Pencatatan data klinis tindakan sirkumsisi pasien: ' . $pendaftaran->pasien->nama_pasien)

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <!-- Patient Summary Card -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex flex-wrap justify-between items-center gap-4">
        <div class="flex items-center space-x-4">
            <span class="w-14 h-14 rounded-2xl bg-emerald-600 text-white font-black text-xl flex items-center justify-center shrink-0">
                {{ $pendaftaran->no_antrean }}
            </span>
            <div>
                <h3 class="text-lg font-extrabold text-slate-900">{{ $pendaftaran->pasien->nama_pasien }}</h3>
                <p class="text-xs text-slate-500">No. RM: <strong class="text-emerald-700 font-mono">{{ $pendaftaran->pasien->no_rm }}</strong> • Usia: {{ $pendaftaran->pasien->usia_tahun }} thn</p>
                <p class="text-xs text-slate-400">Wali: {{ $pendaftaran->pasien->nama_ortu_wali }} ({{ $pendaftaran->pasien->no_wa }})</p>
            </div>
        </div>

        <div class="text-right">
            <span class="text-xs text-slate-400 uppercase font-bold block">Paket Pilihan:</span>
            <span class="text-sm font-bold text-emerald-700">{{ $pendaftaran->paket->nama_paket }}</span>
            <span class="text-xs text-slate-500 block">Metode: {{ ucwords(str_replace('_', ' ', $pendaftaran->paket->metode_sunat)) }}</span>
        </div>
    </div>

    <!-- Form RME -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
        <form action="{{ route('dokter.rekam_medis.store', $pendaftaran->id) }}" method="POST" class="p-8 space-y-6 text-xs">
            @csrf

            <!-- Vital Signs -->
            <div>
                <h4 class="font-bold text-slate-800 uppercase tracking-wider text-xs mb-4 pb-2 border-b border-slate-100 flex items-center">
                    <i class="bi bi-activity text-emerald-600 mr-2"></i> 1. Pemeriksaan Fisik & Tanda Vital
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 uppercase mb-1">Berat Badan (Kg)</label>
                        <input type="number" step="0.1" name="berat_badan" value="{{ old('berat_badan', $rekamMedis->berat_badan ?? '') }}" placeholder="Contoh: 28.5" class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 uppercase mb-1">Tensi Darah (mmHg)</label>
                        <input type="text" name="tensi_darah" value="{{ old('tensi_darah', $rekamMedis->tensi_darah ?? '110/70') }}" placeholder="110/70" class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 uppercase mb-1">Riwayat Alergi Obat</label>
                        <input type="text" name="riwayat_alergi_obat" value="{{ old('riwayat_alergi_obat', $rekamMedis->riwayat_alergi_obat ?? 'Tidak ada riwayat alergi') }}" class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs">
                    </div>
                </div>
            </div>

            <!-- Anatomical & Procedure Details -->
            <div>
                <h4 class="font-bold text-slate-800 uppercase tracking-wider text-xs mb-4 pb-2 border-b border-slate-100 flex items-center">
                    <i class="bi bi-shield-plus text-emerald-600 mr-2"></i> 2. Kondisi Anatomis & Prosedur Sirkumsisi
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 uppercase mb-1">Kondisi Penis / Kulit Preputium</label>
                        <input type="text" name="kondisi_anatomis" value="{{ old('kondisi_anatomis', $rekamMedis->kondisi_anatomis ?? 'Normal, tidak ada fimosis berat') }}" class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 uppercase mb-1">Metode Khitan yang Diterapkan <span class="text-rose-500">*</span></label>
                        <input type="text" name="metode_digunakan" required value="{{ old('metode_digunakan', $rekamMedis->metode_digunakan ?? ucwords(str_replace('_', ' ', $pendaftaran->paket->metode_sunat))) }}" class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-emerald-700">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block font-bold text-slate-700 uppercase mb-1">Catatan Tindakan Sirkumsisi <span class="text-rose-500">*</span></label>
                        <textarea name="catatan_tindakan" rows="3" required placeholder="Langkah asepsis, anastesi infiltrasi needle-free, pemotongan, hemostasis, dan fiksasi alat" class="w-full p-3 rounded-xl border border-slate-300 text-xs font-mono leading-relaxed">{{ old('catatan_tindakan', $rekamMedis->catatan_tindakan ?? "Asepsis dan antisepsis povidone iodine. Anestesi needle-free injection (Comfort-in) lidokain 2% pada pangkal penis. Dilakukan sirkumsisi metode {$pendaftaran->paket->nama_paket}. Hemostasis terkontrol baik, perdarahan minimal.") }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Prescription & Follow Up -->
            <div>
                <h4 class="font-bold text-slate-800 uppercase tracking-wider text-xs mb-4 pb-2 border-b border-slate-100 flex items-center">
                    <i class="bi bi-capsule text-emerald-600 mr-2"></i> 3. Terapi Resep & Rencana Kontrol
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block font-bold text-slate-700 uppercase mb-1">Resep Obat Pasca Khitan <span class="text-rose-500">*</span></label>
                        <textarea name="resep_obat" rows="3" required class="w-full p-3 rounded-xl border border-slate-300 text-xs font-mono leading-relaxed">{{ old('resep_obat', $rekamMedis->resep_obat ?? "1. Amoxicillin syr/tab 500mg 3x1 (Antibiotik)\n2. Paracetamol syr/tab 500mg 3x1 (Pereda Nyeri)\n3. Salep Gentamicin / Chloramphenicol 2x1 dioles tipis") }}</textarea>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 uppercase mb-1">Instruksi Perawatan Bagi Orang Tua</label>
                        <textarea name="instruksi_pasca_sunat" rows="2" class="w-full p-3 rounded-xl border border-slate-300 text-xs">{{ old('instruksi_pasca_sunat', $rekamMedis->instruksi_pasca_sunat ?? 'Jaga kebersihan area penis, gunakan celana sunat pelindung, minum obat teratur, segera hubungi klinik bila ada rembesan darah aktif.') }}</textarea>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 uppercase mb-1">Rencana Tanggal Kontrol Ulang</label>
                        <input type="date" name="tanggal_kontrol_ulang" value="{{ old('tanggal_kontrol_ulang', $rekamMedis && $rekamMedis->tanggal_kontrol_ulang ? $rekamMedis->tanggal_kontrol_ulang->format('Y-m-d') : date('Y-m-d', strtotime('+4 days'))) }}" class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs">
                    </div>
                </div>
            </div>

            <!-- Action Button -->
            <div class="pt-6 border-t border-slate-200 flex justify-between items-center">
                <a href="{{ route('dokter.antrean') }}" class="text-xs font-bold text-slate-500 hover:text-slate-700">
                    <i class="bi bi-arrow-left mr-1"></i> Kembali ke Antrean
                </a>
                <button type="submit" class="px-7 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold rounded-xl shadow text-xs flex items-center">
                    <i class="bi bi-check2-circle mr-1.5"></i> Simpan Rekam Medis & Selesaikan Tindakan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection