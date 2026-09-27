@extends('layouts.admin')

@section('title', 'Kelola Pendaftaran & Verifikasi DP')
@section('page_title', 'Manajemen Pendaftaran & Uang Muka (DP)')
@section('page_subtitle', 'Verifikasi bukti pembayaran transfer DP dan konfirmasi nomor antrean pasien')

@section('content')
<!-- Filter & Action Header -->
<div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs mb-8">
    <form action="{{ route('admin.pendaftaran') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-center">
        <div class="sm:col-span-4">
            <input type="text" name="q" value="{{ $search }}" placeholder="Cari No. Reg, Antrean, Nama Pasien..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
        </div>

        <div class="sm:col-span-3">
            <select name="status_bayar" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                <option value="">-- Semua Status Pembayaran --</option>
                <option value="belum_bayar" {{ $statusBayar === 'belum_bayar' ? 'selected' : '' }}>Belum Bayar DP</option>
                <option value="menunggu_verifikasi" {{ $statusBayar === 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi DP</option>
                <option value="dp_lunas" {{ $statusBayar === 'dp_lunas' ? 'selected' : '' }}>DP Lunas (Terkonfirmasi)</option>
                <option value="lunas" {{ $statusBayar === 'lunas' ? 'selected' : '' }}>Lunas Seluruhnya</option>
            </select>
        </div>

        <div class="sm:col-span-3">
            <select name="status_pelayanan" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                <option value="">-- Semua Status Pelayanan --</option>
                <option value="menunggu" {{ $statusPelayanan === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="terkonfirmasi" {{ $statusPelayanan === 'terkonfirmasi' ? 'selected' : '' }}>Terkonfirmasi</option>
                <option value="tindakan" {{ $statusPelayanan === 'tindakan' ? 'selected' : '' }}>Tindakan</option>
                <option value="selesai" {{ $statusPelayanan === 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>

        <div class="sm:col-span-2 flex space-x-2">
            <button type="submit" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow transition">
                <i class="bi bi-filter mr-1"></i> Filter
            </button>
            <a href="{{ route('admin.pendaftaran') }}" class="p-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition">
                <i class="bi bi-arrow-counterclockwise"></i>
            </a>
        </div>
    </form>
</div>

<!-- Data Table -->
<div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="bg-slate-50 text-slate-400 uppercase font-bold border-b border-slate-200/60">
                    <th class="p-4 pl-6">No. Antrean & Reg</th>
                    <th class="p-4">Pasien & Wali</th>
                    <th class="p-4">Paket & Dokter</th>
                    <th class="p-4">Jadwal Tindakan</th>
                    <th class="p-4">Rincian Keuangan</th>
                    <th class="p-4">Bukti DP</th>
                    <th class="p-4 pr-6 text-center">Aksi Verifikasi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($pendaftarans as $p)
                <tr class="hover:bg-slate-50/80 transition">
                    <td class="p-4 pl-6">
                        <span class="text-base font-black text-emerald-700 font-mono block">{{ $p->no_antrean }}</span>
                        <span class="font-mono text-slate-400 text-[11px]">{{ $p->no_registrasi }}</span>
                    </td>
                    <td class="p-4">
                        <span class="font-extrabold text-slate-800 block text-sm">{{ $p->pasien->nama_pasien }}</span>
                        <span class="text-slate-500 text-xs">{{ $p->pasien->nama_ortu_wali }} ({{ $p->pasien->no_wa }})</span>
                    </td>
                    <td class="p-4">
                        <span class="font-bold text-slate-700 block">{{ $p->paket->nama_paket }}</span>
                        <span class="text-slate-500 text-[11px]">{{ $p->dokter->nama_dokter }}</span>
                    </td>
                    <td class="p-4">
                        <span class="font-semibold text-slate-800 block">{{ $p->tanggal_kunjungan->format('d/m/Y') }}</span>
                        <span class="text-xs text-emerald-600 font-semibold">{{ substr($p->jam_kunjungan, 0, 5) }} WIB</span>
                        <span class="text-[10px] uppercase tracking-wider block font-bold text-slate-400 mt-0.5">{{ $p->jenis_layanan }}</span>
                    </td>
                    <td class="p-4 space-y-0.5">
                        <div class="flex justify-between gap-4 text-[11px]">
                            <span class="text-slate-400">Total:</span>
                            <span class="font-bold text-slate-800">Rp {{ number_format($p->total_biaya, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between gap-4 text-[11px]">
                            <span class="text-slate-400">DP:</span>
                            <span class="font-bold text-amber-600">Rp {{ number_format($p->nominal_dp, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between gap-4 text-[11px]">
                            <span class="text-slate-400">Sisa:</span>
                            <span class="font-bold text-emerald-700">Rp {{ number_format($p->sisa_pembayaran, 0, ',', '.') }}</span>
                        </div>
                    </td>
                    <td class="p-4">
                        @if($p->bukti_pembayaran)
                        <button type="button" onclick="showProofModal('{{ asset('assets/uploads/bukti_dp/' . $p->bukti_pembayaran) }}')" class="px-3 py-1.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 rounded-lg text-xs font-bold transition flex items-center">
                            <i class="bi bi-eye mr-1"></i> Lihat Bukti
                        </button>
                        @else
                        <span class="text-slate-400 text-xs italic">Belum Ada</span>
                        @endif
                    </td>
                    <td class="p-4 pr-6 text-center space-y-1">
                        <!-- Status Pill -->
                        <div>
                            @if($p->status_pembayaran === 'dp_lunas')
                            <span class="px-2.5 py-1 bg-blue-100 text-blue-800 rounded-full font-bold text-[11px]">DP Lunas</span>
                            @elseif($p->status_pembayaran === 'menunggu_verifikasi')
                            <span class="px-2.5 py-1 bg-amber-100 text-amber-800 rounded-full font-bold text-[11px]">Cek Bukti DP</span>
                            @elseif($p->status_pembayaran === 'lunas')
                            <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 rounded-full font-bold text-[11px]">Lunas</span>
                            @else
                            <span class="px-2.5 py-1 bg-rose-100 text-rose-800 rounded-full font-bold text-[11px]">Belum Bayar</span>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-center gap-1.5 pt-1">
                            @if($p->status_pembayaran === 'menunggu_verifikasi' || $p->status_pembayaran === 'belum_bayar')
                            <form action="{{ route('admin.pendaftaran.verifikasi_dp', $p->id) }}" method="POST">
                                @csrf
                                <button type="submit" title="Verifikasi & ACC DP" class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-bold text-[11px] transition">
                                    ACC DP
                                </button>
                            </form>
                            @endif

                            @if($p->status_pembayaran === 'dp_lunas')
                            <form action="{{ route('admin.pendaftaran.pelunasan', $p->id) }}" method="POST">
                                @csrf
                                <button type="submit" title="Pelunasan di Kasir" class="px-2.5 py-1 bg-teal-600 hover:bg-teal-700 text-white rounded-lg font-bold text-[11px] transition">
                                    Pelunasan
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-8 text-center text-slate-400">Tidak ada data pendaftaran yang sesuai kriteria filter.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-4 border-t border-slate-100">
        {{ $pendaftarans->withQueryString()->links() }}
    </div>
</div>

<!-- Modal Preview Bukti Transfer -->
<div id="proofModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full overflow-hidden shadow-2xl">
        <div class="p-4 bg-slate-50 border-b border-slate-200 flex justify-between items-center">
            <h4 class="font-bold text-slate-900 text-sm">Pratinjau Bukti Pembayaran DP</h4>
            <button type="button" onclick="closeProofModal()" class="text-slate-400 hover:text-slate-600 p-1">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="p-4 text-center">
            <img id="modalImg" src="" alt="Bukti Transfer" class="max-h-96 mx-auto rounded-xl object-contain border border-slate-200">
        </div>
        <div class="p-4 bg-slate-50 border-t border-slate-200 flex justify-end">
            <button type="button" onclick="closeProofModal()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-xs rounded-xl">
                Tutup
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function showProofModal(url) {
        document.getElementById('modalImg').src = url;
        document.getElementById('proofModal').classList.remove('hidden');
    }

    function closeProofModal() {
        document.getElementById('proofModal').classList.add('hidden');
    }
</script>
@endpush