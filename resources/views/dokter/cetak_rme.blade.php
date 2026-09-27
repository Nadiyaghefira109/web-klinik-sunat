<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembar Rekam Medis - {{ $pendaftaran->pasien->nama_pasien }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
            }
        }
    </style>
</head>

<body class="bg-slate-100 p-6 text-slate-800">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow border border-slate-200" id="printArea">
        <!-- Letterhead -->
        <div class="text-center pb-4 border-b-2 border-slate-900 mb-6">
            <h1 class="text-xl font-extrabold uppercase text-slate-900">RUMAH SUNAT ELNARA (KLINIK EL MEDIKA)</h1>
            <p class="text-xs text-slate-600">Pelayanan Sirkumsisi Modern Ramah Anak & Khitan Dewasa</p>
            <p class="text-xs text-slate-500">Jl. Raden Intan No. 88, Bandar Lampung • SIP Dokter: 503/446/SIP.D/2024</p>
            <div class="mt-2 inline-block px-4 py-1 bg-slate-900 text-white text-xs font-bold uppercase rounded">
                LEMBAR REKAM MEDIS ELEKTRONIK SIRKUMSISI
            </div>
        </div>

        <!-- Identitas Pasien -->
        <div class="grid grid-cols-2 gap-4 text-xs mb-6 p-4 bg-slate-50 rounded-xl border border-slate-200">
            <div>
                <span class="text-slate-400 block">Nomor Rekam Medis (RM):</span>
                <span class="font-mono font-bold text-sm text-emerald-800">{{ $pendaftaran->pasien->no_rm }}</span>
                <span class="text-slate-400 block mt-2">Nama Pasien:</span>
                <span class="font-bold text-slate-900">{{ $pendaftaran->pasien->nama_pasien }}</span>
                <span class="text-slate-400 block mt-2">Usia / Tgl Lahir:</span>
                <span class="font-medium text-slate-700">{{ $pendaftaran->pasien->usia_tahun }} Tahun ({{ $pendaftaran->pasien->tanggal_lahir }})</span>
            </div>
            <div>
                <span class="text-slate-400 block">No. Registrasi / Antrean:</span>
                <span class="font-mono font-bold text-sm text-slate-800">{{ $pendaftaran->no_registrasi }} / {{ $pendaftaran->no_antrean }}</span>
                <span class="text-slate-400 block mt-2">Orang Tua / Wali:</span>
                <span class="font-medium text-slate-700">{{ $pendaftaran->pasien->nama_ortu_wali }} ({{ $pendaftaran->pasien->no_wa }})</span>
                <span class="text-slate-400 block mt-2">Paket Khitan:</span>
                <span class="font-bold text-emerald-700">{{ $pendaftaran->paket->nama_paket }}</span>
            </div>
        </div>

        <!-- Clinical Notes -->
        @php $rm = $pendaftaran->rekamMedis; @endphp
        <div class="space-y-4 text-xs">
            <div class="border-b border-slate-200 pb-3">
                <span class="font-bold text-slate-700 uppercase block mb-1">1. Pemeriksaan Fisik & Tanda Vital:</span>
                <p class="text-slate-600">Berat Badan: <strong>{{ $rm->berat_badan ?? '-' }} Kg</strong> | Tensi Darah: <strong>{{ $rm->tensi_darah ?? '-' }} mmHg</strong> | Alergi: <strong>{{ $rm->riwayat_alergi_obat ?? 'Tidak ada' }}</strong></p>
            </div>

            <div class="border-b border-slate-200 pb-3">
                <span class="font-bold text-slate-700 uppercase block mb-1">2. Catatan Tindakan Bedah Minor Sirkumsisi:</span>
                <p class="text-slate-600 mb-1">Metode Khitan: <strong>{{ $rm->metode_digunakan ?? $pendaftaran->paket->nama_paket }}</strong></p>
                <p class="text-slate-600 font-mono whitespace-pre-line bg-slate-50 p-2.5 rounded-lg">{{ $rm->catatan_tindakan ?? 'Tindakan sirkumsisi berjalan lancar.' }}</p>
            </div>

            <div class="border-b border-slate-200 pb-3">
                <span class="font-bold text-slate-700 uppercase block mb-1">3. Terapi Resep Obat:</span>
                <p class="text-slate-600 font-mono whitespace-pre-line bg-slate-50 p-2.5 rounded-lg">{{ $rm->resep_obat ?? 'Amoxicillin, Paracetamol, Salep' }}</p>
            </div>

            <div>
                <span class="font-bold text-slate-700 uppercase block mb-1">4. Jadwal Kontrol Ulang:</span>
                <p class="text-slate-600">Rencana Kontrol: <strong>{{ $rm && $rm->tanggal_kontrol_ulang ? $rm->tanggal_kontrol_ulang->format('d/m/Y') : 'H+4 Pasca Tindakan' }}</strong></p>
            </div>
        </div>

        <!-- Signature -->
        <div class="mt-12 pt-6 flex justify-between items-end text-xs text-slate-700">
            <div class="no-print">
                <button onclick="window.print()" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl shadow">
                    Cetak Lembar RME
                </button>
            </div>
            <div class="text-center space-y-12">
                <p>Bandar Lampung, {{ $pendaftaran->tanggal_kunjungan->format('d/m/Y') }}<br><strong>Dokter Pelaksana Sirkumsisi</strong></p>
                <p class="font-bold underline pt-4">{{ $pendaftaran->dokter->nama_dokter }}</p>
            </div>
        </div>
    </div>
</body>

</html>