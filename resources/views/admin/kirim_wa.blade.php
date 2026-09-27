@extends('layouts.admin')

@section('title', 'WhatsApp Gateway Assistant')
@section('page_title', 'Asisten Notifikasi WhatsApp Gateway')
@section('page_subtitle', 'Kirim pesan konfirmasi pendaftaran, pengingat jadwal, dan instruksi kontrol ke wali pasien')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- Form Kirim WA -->
    <div class="lg:col-span-6 bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs">
        <h3 class="text-base font-extrabold text-slate-900 mb-4 flex items-center">
            <i class="bi bi-whatsapp text-emerald-600 mr-2 text-xl"></i> Form Kirim Pesan Cepat
        </h3>

        <form action="{{ route('admin.kirim_wa.store') }}" method="POST" class="space-y-4 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Pilih Pasien / Pendaftaran</label>
                <select name="id_pendaftaran" id="selectPendaftaran" required class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500">
                    <option value="">-- Pilih Pasien --</option>
                    @foreach($pendaftarans as $p)
                    <option value="{{ $p->id }}"
                        data-nama="{{ $p->pasien->nama_pasien }}"
                        data-wali="{{ $p->pasien->nama_ortu_wali }}"
                        data-wa="{{ $p->pasien->no_wa }}"
                        data-antrean="{{ $p->no_antrean }}"
                        data-reg="{{ $p->no_registrasi }}"
                        data-tgl="{{ $p->tanggal_kunjungan->format('d/m/Y') }}"
                        data-jam="{{ substr($p->jam_kunjungan, 0, 5) }}">
                        {{ $p->no_antrean }} - {{ $p->pasien->nama_pasien }} (Wali: {{ $p->pasien->nama_ortu_wali }})
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">No. WhatsApp Tujuan</label>
                <input type="text" name="no_wa_tujuan" id="no_wa_tujuan" required placeholder="08xxxxxxxxxx" class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs">
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Jenis Notifikasi</label>
                <select name="jenis_notifikasi" id="jenis_notifikasi" required class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs">
                    <option value="konfirmasi_daftar">Konfirmasi Pendaftaran & No. Antrean</option>
                    <option value="pengingat_jadwal">Pengingat Jadwal Tindakan (H-1)</option>
                    <option value="jadwal_kontrol">Jadwal Kontrol Pasca Khitan</option>
                    <option value="pesan_manual">Pesan Khusus / Manual</option>
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Isi Pesan WhatsApp</label>
                <textarea name="isi_pesan" id="isi_pesan" rows="6" required class="w-full p-3 rounded-xl border border-slate-300 text-xs font-mono leading-relaxed"></textarea>
            </div>

            <div class="pt-2 flex justify-end">
                <button type="submit" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow flex items-center">
                    <i class="bi bi-send mr-1.5"></i> Buka WhatsApp & Kirim Pesan
                </button>
            </div>
        </form>
    </div>

    <!-- Log Pesan Terkirim -->
    <div class="lg:col-span-6 bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-base font-extrabold text-slate-900">Riwayat Pesan Terkirim</h3>
            <span class="text-xs text-slate-400">20 pesan terakhir</span>
        </div>

        <div class="p-6 space-y-3 overflow-y-auto max-h-[500px]">
            @forelse($logs as $log)
            <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200 text-xs space-y-1">
                <div class="flex justify-between items-center">
                    <span class="font-bold text-slate-800">{{ $log->no_wa_tujuan }}</span>
                    <span class="text-[10px] text-slate-400">{{ $log->sent_at ? $log->sent_at->format('d/m/Y H:i') : '-' }}</span>
                </div>
                <span class="inline-block px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded font-semibold text-[10px] uppercase">
                    {{ str_replace('_', ' ', $log->jenis_notifikasi) }}
                </span>
                <p class="text-slate-600 text-[11px] line-clamp-2 mt-1">{{ $log->isi_pesan }}</p>
            </div>
            @empty
            <p class="text-center text-xs text-slate-400 py-6">Belum ada riwayat pesan WhatsApp.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const select = document.getElementById('selectPendaftaran');
    const inputWa = document.getElementById('no_wa_tujuan');
    const inputJenis = document.getElementById('jenis_notifikasi');
    const areaPesan = document.getElementById('isi_pesan');

    function updateTemplate() {
        if (!select || !select.selectedIndex) return;
        const opt = select.options[select.selectedIndex];
        if (!opt || !opt.value) return;

        const nama = opt.getAttribute('data-nama');
        const wali = opt.getAttribute('data-wali');
        const wa = opt.getAttribute('data-wa');
        const antrean = opt.getAttribute('data-antrean');
        const reg = opt.getAttribute('data-reg');
        const tgl = opt.getAttribute('data-tgl');
        const jam = opt.getAttribute('data-jam');

        inputWa.value = wa;

        const jenis = inputJenis.value;
        if (jenis === 'konfirmasi_daftar') {
            areaPesan.value = `Halo Bapak/Ibu ${wali},\n\nTerima kasih telah mendaftarkan ananda ${nama} di Rumah Sunat Elnara (Klinik El Medika).\n\nNo. Registrasi: ${reg}\nNo. Antrean: ${antrean}\nJadwal Tindakan: ${tgl} pukul ${jam} WIB.\n\nMohon hadir 15 menit sebelum sesi dimulai. Terima kasih.`;
        } else if (jenis === 'pengingat_jadwal') {
            areaPesan.value = `Halo Bapak/Ibu ${wali},\n\nPengingat jadwal sirkumsisi ananda ${nama} besok (${tgl}) pukul ${jam} WIB di Klinik El Medika.\nNomor antrean: ${antrean}.\n\nPastikan ananda dalam kondisi sehat dan sudah makan sebelum tindakan.`;
        } else if (jenis === 'jadwal_kontrol') {
            areaPesan.value = `Halo Bapak/Ibu ${wali},\n\nMengingatkan jadwal kontrol pasca khitan ananda ${nama} di Klinik El Medika. Mohon kabari kondisi luka ananda kepada dokter bertugas. Terima kasih.`;
        }
    }

    select.addEventListener('change', updateTemplate);
    inputJenis.addEventListener('change', updateTemplate);
</script>
@endpush