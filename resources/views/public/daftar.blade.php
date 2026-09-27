@extends('layouts.app')

@section('title', 'Pendaftaran Sirkumsisi Online - Rumah Sunat Elnara')

@section('content')
<div class="bg-gradient-to-b from-emerald-900 to-teal-800 text-white py-12">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <span class="inline-block px-3 py-1 bg-emerald-700/60 border border-emerald-500/40 rounded-full text-xs font-semibold text-emerald-200 uppercase tracking-wider mb-2">
            Reservasi Mandiri Cepat & Praktis
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Formulir Pendaftaran Sirkumsisi Online</h1>
        <p class="mt-2 text-emerald-100 text-sm max-w-xl mx-auto">
            Lengkapi data pasien, pilih dokter dan jadwal, serta amankan antrean tindakan dengan komitmen uang muka (DP).
        </p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 py-12 -mt-6">
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200/80 overflow-hidden">
        <form action="{{ route('daftar.store') }}" method="POST" enctype="multipart/form-data" class="p-8 sm:p-10 space-y-8" id="formPendaftaran">
            @csrf

            <!-- Section 1: Data Pasien -->
            <div>
                <div class="flex items-center space-x-3 pb-3 border-b border-slate-200 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm">1</div>
                    <h2 class="text-lg font-bold text-slate-900">Identitas Pasien & Wali</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap Pasien / Anak <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_pasien" required value="{{ old('nama_pasien') }}" placeholder="Contoh: Muhammad Al-Fatih" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm transition">
                        @error('nama_pasien') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal Lahir <span class="text-rose-500">*</span></label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" required value="{{ old('tanggal_lahir') }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm transition">
                        <span id="usiaKalkulasi" class="text-xs text-emerald-600 font-semibold mt-1 block"></span>
                        @error('tanggal_lahir') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jenis Kelamin <span class="text-rose-500">*</span></label>
                        <select name="jenis_kelamin" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm transition">
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">NIK Pasien (Opsional)</label>
                        <input type="text" name="nik" value="{{ old('nik') }}" placeholder="16 Digit NIK KTP / KIA" maxlength="20" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Orang Tua / Penanggung Jawab <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_ortu_wali" required value="{{ old('nama_ortu_wali') }}" placeholder="Contoh: Hendra Wijaya" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm transition">
                        @error('nama_ortu_wali') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">No. WhatsApp Aktif <span class="text-rose-500">*</span></label>
                        <input type="text" name="no_wa" required value="{{ old('no_wa') }}" placeholder="08xxxxxxxxxx (untuk kirim tiket & notif)" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm transition">
                        @error('no_wa') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat Domisili Lengkap <span class="text-rose-500">*</span></label>
                        <textarea name="alamat_lengkap" rows="2" required placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm transition">{{ old('alamat_lengkap') }}</textarea>
                        @error('alamat_lengkap') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Section 2: Pemilihan Paket & Tindakan -->
            <div>
                <div class="flex items-center space-x-3 pb-3 border-b border-slate-200 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm">2</div>
                    <h2 class="text-lg font-bold text-slate-900">Pilihan Paket & Jadwal Pelayanan</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pilih Paket Khitan Modern <span class="text-rose-500">*</span></label>
                        <select name="id_paket" id="selectPaket" required class="w-full px-4 py-3.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm transition font-medium">
                            <option value="">-- Pilih Paket Khitan --</option>
                            @foreach($pakets as $pkt)
                            <option value="{{ $pkt->id }}"
                                data-harga="{{ $pkt->harga }}"
                                data-dp="{{ $pkt->nominal_dp }}"
                                data-metode="{{ ucwords(str_replace('_', ' ', $pkt->metode_sunat)) }}"
                                {{ (old('id_paket') == $pkt->id || $selectedPaketId == $pkt->id) ? 'selected' : '' }}>
                                {{ $pkt->nama_paket }} - {{ $pkt->harga_format }} (Wajib DP: {{ $pkt->nominal_dp_format }})
                            </option>
                            @endforeach
                        </select>
                        @error('id_paket') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Realtime Financial Box -->
                    <div class="sm:col-span-2 p-5 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-2xl border border-emerald-200 space-y-3" id="financialBox">
                        <h3 class="text-xs font-bold text-emerald-800 uppercase tracking-wider flex items-center">
                            <i class="bi bi-calculator mr-1.5"></i> Ringkasan Finansial Paket Terpilih
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-center sm:text-left">
                            <div class="bg-white p-3 rounded-xl border border-emerald-100">
                                <span class="text-xs text-slate-500 block">Total Biaya Paket</span>
                                <span class="text-base font-extrabold text-slate-800" id="boxTotalBiaya">Rp 0</span>
                            </div>
                            <div class="bg-white p-3 rounded-xl border border-emerald-100">
                                <span class="text-xs text-amber-700 font-bold block">Uang Muka (Wajib DP)</span>
                                <span class="text-base font-extrabold text-amber-600" id="boxNominalDp">Rp 0</span>
                            </div>
                            <div class="bg-white p-3 rounded-xl border border-emerald-100">
                                <span class="text-xs text-slate-500 block">Sisa Pelunasan di Tempat</span>
                                <span class="text-base font-extrabold text-emerald-700" id="boxSisaBayar">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Dokter / Operator Khitan <span class="text-rose-500">*</span></label>
                        <select name="id_dokter" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm transition">
                            <option value="">-- Pilih Dokter Bertugas --</option>
                            @foreach($dokters as $dok)
                            <option value="{{ $dok->id }}" {{ old('id_dokter') == $dok->id ? 'selected' : '' }}>
                                {{ $dok->nama_dokter }} ({{ $dok->spesialisasi }})
                            </option>
                            @endforeach
                        </select>
                        @error('id_dokter') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Lokasi Pelayanan <span class="text-rose-500">*</span></label>
                        <select name="jenis_layanan" id="jenis_layanan" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm transition">
                            <option value="klinik" {{ old('jenis_layanan') == 'klinik' ? 'selected' : '' }}>Tindakan di Klinik (Elnara Medika)</option>
                            <option value="home_care" {{ old('jenis_layanan') == 'home_care' ? 'selected' : '' }}>Sunat di Rumah (Home Care)</option>
                        </select>
                    </div>

                    <div id="homeCareAddressBox" class="sm:col-span-2 hidden">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat Penjemputan / Kunjungan Home Care</label>
                        <textarea name="alamat_home_care" rows="2" placeholder="Tuliskan petunjuk arah / patokan rumah jika berbeda dengan domisili" class="w-full px-4 py-3 rounded-xl border border-amber-300 bg-amber-50/50 text-sm transition">{{ old('alamat_home_care') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Rencana Tanggal Tindakan <span class="text-rose-500">*</span></label>
                        <input type="date" name="tanggal_kunjungan" min="{{ date('Y-m-d') }}" required value="{{ old('tanggal_kunjungan', date('Y-m-d')) }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm transition">
                        @error('tanggal_kunjungan') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pilihan Sesi Jam <span class="text-rose-500">*</span></label>
                        <select name="jam_kunjungan" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm transition">
                            <option value="08:30:00" {{ old('jam_kunjungan') == '08:30:00' ? 'selected' : '' }}>Sesi Pagi: 08.30 WIB</option>
                            <option value="10:00:00" {{ old('jam_kunjungan') == '10:00:00' ? 'selected' : '' }}>Sesi Pagi: 10.00 WIB</option>
                            <option value="13:30:00" {{ old('jam_kunjungan') == '13:30:00' ? 'selected' : '' }}>Sesi Siang: 13.30 WIB</option>
                            <option value="15:30:00" {{ old('jam_kunjungan') == '15:30:00' ? 'selected' : '' }}>Sesi Sore: 15.30 WIB</option>
                            <option value="19:00:00" {{ old('jam_kunjungan') == '19:00:00' ? 'selected' : '' }}>Sesi Malam: 19.00 WIB</option>
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Keluhan / Catatan Medis Awal</label>
                        <input type="text" name="keluhan_awal" value="{{ old('keluhan_awal') }}" placeholder="Contoh: Tidak ada keluhan, atau anak memiliki fobia jarum suntik, riwayat fimosis" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm transition">
                    </div>
                </div>
            </div>

            <!-- Section 3: Pembayaran Uang Muka (DP) & Rekening Klinik -->
            <div>
                <div class="flex items-center space-x-3 pb-3 border-b border-slate-200 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm">3</div>
                    <h2 class="text-lg font-bold text-slate-900">Pembayaran Uang Muka (DP) & Verifikasi</h2>
                </div>

                <!-- Rekening Resmi Box -->
                <div class="p-6 bg-slate-50 rounded-2xl border border-slate-200 space-y-4 mb-6">
                    <span class="text-xs font-bold text-slate-700 uppercase tracking-wider block">Rekening Resmi Klinik El Medika:</span>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-4 bg-white rounded-xl border border-slate-200 flex justify-between items-center">
                            <div>
                                <span class="text-xs font-bold text-blue-700 block">BANK BCA</span>
                                <span class="text-sm font-mono font-bold text-slate-800">023-8899-123</span>
                                <span class="text-xs text-slate-500 block">a.n. Klinik El Medika</span>
                            </div>
                            <button type="button" onclick="navigator.clipboard.writeText('0238899123'); Swal.fire('Tersalin!', 'No. Rekening BCA telah disalin', 'success');" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 bg-emerald-50 px-2.5 py-1.5 rounded-lg">
                                Salin
                            </button>
                        </div>

                        <div class="p-4 bg-white rounded-xl border border-slate-200 flex justify-between items-center">
                            <div>
                                <span class="text-xs font-bold text-amber-700 block">BANK MANDIRI</span>
                                <span class="text-sm font-mono font-bold text-slate-800">114-00-1988221-1</span>
                                <span class="text-xs text-slate-500 block">a.n. Rumah Sunat Elnara</span>
                            </div>
                            <button type="button" onclick="navigator.clipboard.writeText('1140019882211'); Swal.fire('Tersalin!', 'No. Rekening Mandiri telah disalin', 'success');" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 bg-emerald-50 px-2.5 py-1.5 rounded-lg">
                                Salin
                            </button>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Metode Pembayaran DP</label>
                        <select name="metode_pembayaran" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm transition">
                            <option value="Transfer BCA">Transfer Bank BCA</option>
                            <option value="Transfer Mandiri">Transfer Bank Mandiri</option>
                            <option value="Transfer BSI">Transfer Bank BSI</option>
                            <option value="Transfer BRI">Transfer Bank BRI</option>
                            <option value="QRIS Elnara">QRIS Resmi Elnara</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Upload Bukti Transfer DP (Opsional)</label>
                        <input type="file" name="bukti_pembayaran" accept=".jpg,.jpeg,.png,.pdf" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-slate-300 rounded-xl">
                        <span class="text-xs text-slate-400 mt-1 block">Format JPG, PNG, atau PDF (Maks. 3 MB). Bukti transfer juga dapat diunggah nanti di halaman tiket.</span>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-6 border-t border-slate-200 flex justify-end">
                <button type="submit" class="px-8 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-extrabold rounded-2xl shadow-xl shadow-emerald-600/30 text-base transition transform hover:-translate-y-0.5">
                    <i class="bi bi-send-check mr-2"></i> Kirim Pendaftaran & Dapatkan Tiket
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Realtime Financial Calculator
    const selectPaket = document.getElementById('selectPaket');
    const boxTotalBiaya = document.getElementById('boxTotalBiaya');
    const boxNominalDp = document.getElementById('boxNominalDp');
    const boxSisaBayar = document.getElementById('boxSisaBayar');

    function formatRupiah(val) {
        return 'Rp ' + Number(val).toLocaleString('id-ID');
    }

    function calculateFinance() {
        if (!selectPaket) return;
        const selected = selectPaket.options[selectPaket.selectedIndex];
        if (selected && selected.value) {
            const harga = Number(selected.getAttribute('data-harga') || 0);
            const dp = Number(selected.getAttribute('data-dp') || 0);
            const sisa = Math.max(0, harga - dp);

            boxTotalBiaya.innerText = formatRupiah(harga);
            boxNominalDp.innerText = formatRupiah(dp);
            boxSisaBayar.innerText = formatRupiah(sisa);
        } else {
            boxTotalBiaya.innerText = 'Rp 0';
            boxNominalDp.innerText = 'Rp 0';
            boxSisaBayar.innerText = 'Rp 0';
        }
    }

    selectPaket.addEventListener('change', calculateFinance);
    calculateFinance(); // run initially

    // Toggle Home care box
    const jenisLayanan = document.getElementById('jenis_layanan');
    const homeCareBox = document.getElementById('homeCareAddressBox');
    if (jenisLayanan && homeCareBox) {
        jenisLayanan.addEventListener('change', function() {
            if (this.value === 'home_care') {
                homeCareBox.classList.remove('hidden');
            } else {
                homeCareBox.classList.add('hidden');
            }
        });
        if (jenisLayanan.value === 'home_care') homeCareBox.classList.remove('hidden');
    }
</script>
@endpush