@extends('layouts.admin')

@section('title', 'Master Paket & Tarif Khitan')
@section('page_title', 'Pengelolaan Paket Khitan & Tarif')
@section('page_subtitle', 'Atur harga, ketentuan DP, deskripsi keunggulan medis, dan foto banner paket')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h3 class="text-base font-bold text-slate-900">Daftar Paket Khitan Modern</h3>
        <p class="text-xs text-slate-500">Seluruh paket yang aktif akan tampil di katalog publik</p>
    </div>
    <button type="button" onclick="openAddModal()" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow transition flex items-center">
        <i class="bi bi-plus-lg mr-1.5"></i> Tambah Paket Baru
    </button>
</div>

<!-- Table Paket -->
<div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="bg-slate-50 text-slate-400 uppercase font-bold border-b border-slate-200/60">
                    <th class="p-4 pl-6">Foto</th>
                    <th class="p-4">Nama Paket & Kategori</th>
                    <th class="p-4">Metode Sunat</th>
                    <th class="p-4">Total Tarif</th>
                    <th class="p-4">Nominal DP</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 pr-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($pakets as $pkt)
                <tr class="hover:bg-slate-50/80 transition">
                    <td class="p-4 pl-6">
                        <img src="{{ asset('assets/img/' . $pkt->gambar) }}" alt="{{ $pkt->nama_paket }}" class="w-14 h-14 rounded-xl object-cover border border-slate-200 shadow-xs">
                    </td>
                    <td class="p-4">
                        <span class="font-extrabold text-slate-900 block text-sm">{{ $pkt->nama_paket }}</span>
                        <span class="text-emerald-600 font-semibold uppercase text-[10px] tracking-wider">{{ $pkt->kategori_layanan }}</span>
                    </td>
                    <td class="p-4">
                        <span class="px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg font-semibold text-[11px]">
                            {{ ucwords(str_replace('_', ' ', $pkt->metode_sunat)) }}
                        </span>
                    </td>
                    <td class="p-4 font-bold text-slate-900 text-sm">
                        {{ $pkt->harga_format }}
                    </td>
                    <td class="p-4 font-bold text-amber-600 text-sm">
                        {{ $pkt->nominal_dp_format }}
                    </td>
                    <td class="p-4">
                        <a href="{{ route('admin.paket.toggle', $pkt->id) }}" class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase transition {{ $pkt->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                            {{ $pkt->is_active ? 'Aktif' : 'Nonaktif' }}
                        </a>
                    </td>
                    <td class="p-4 pr-6 text-center">
                        <button type="button" onclick="openEditModal({{ json_encode($pkt) }})" class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded-xl transition text-xs shadow-xs">
                            <i class="bi bi-pencil-square"></i> Edit
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Form Tambah / Edit Paket -->
<div id="paketModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-2xl w-full overflow-hidden shadow-2xl max-h-[90vh] flex flex-col">
        <div class="p-5 bg-slate-50 border-b border-slate-200 flex justify-between items-center">
            <h4 class="font-bold text-slate-900 text-base" id="modalTitle">Tambah Paket Khitan</h4>
            <button type="button" onclick="closePaketModal()" class="text-slate-400 hover:text-slate-600 p-1">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <form id="formPaket" action="{{ route('admin.paket.store') }}" method="POST" enctype="multipart/form-data" class="p-6 overflow-y-auto space-y-4 text-xs">
            @csrf
            <div id="methodField"></div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block font-bold text-slate-700 uppercase mb-1">Nama Paket</label>
                    <input type="text" name="nama_paket" id="m_nama_paket" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Kategori Layanan</label>
                    <select name="kategori_layanan" id="m_kategori_layanan" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        <option value="anak">Sunat Anak</option>
                        <option value="rumah">Sunat Di Rumah (Home Care)</option>
                        <option value="premium">Sunat Premium VIP</option>
                        <option value="dewasa">Sunat Dewasa</option>
                        <option value="bayi">Sunat Bayi</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Metode Khitan</label>
                    <select name="metode_sunat" id="m_metode_sunat" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        <option value="mahdian_klem">Mahdian Klem</option>
                        <option value="circum_pen">Circum Pen Super</option>
                        <option value="gun_stapler">Gun Stapler</option>
                        <option value="konvensional_laser">Konvensional Laser</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Tarif Resmi (Rp)</label>
                    <input type="number" name="harga" id="m_harga" required min="0" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Nominal Wajib DP (Rp)</label>
                    <input type="number" name="nominal_dp" id="m_nominal_dp" required min="0" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                </div>

                <div class="sm:col-span-2">
                    <label class="block font-bold text-slate-700 uppercase mb-1">Deskripsi Singkat</label>
                    <textarea name="deskripsi" id="m_deskripsi" rows="2" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs"></textarea>
                </div>

                <div class="sm:col-span-2">
                    <label class="block font-bold text-slate-700 uppercase mb-1">Keunggulan Medis (1 baris per poin)</label>
                    <textarea name="keunggulan" id="m_keunggulan" rows="2" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs"></textarea>
                </div>

                <div class="sm:col-span-2">
                    <label class="block font-bold text-slate-700 uppercase mb-1">Foto Banner Paket</label>
                    <input type="file" name="gambar" accept=".jpg,.jpeg,.png,.webp" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-emerald-50 file:text-emerald-700 border border-slate-300 rounded-xl">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-200 flex justify-end space-x-2">
                <button type="button" onclick="closePaketModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow">
                    Simpan Paket
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const modal = document.getElementById('paketModal');
    const form = document.getElementById('formPaket');
    const modalTitle = document.getElementById('modalTitle');

    function openAddModal() {
        form.reset();
        form.action = "{{ route('admin.paket.store') }}";
        document.getElementById('methodField').innerHTML = '';
        modalTitle.innerText = "Tambah Paket Khitan Baru";
        modal.classList.remove('hidden');
    }

    function openEditModal(paket) {
        form.reset();
        form.action = "/admin/paket/" + paket.id + "/update";
        document.getElementById('methodField').innerHTML = '';
        modalTitle.innerText = "Edit Paket: " + paket.nama_paket;

        document.getElementById('m_nama_paket').value = paket.nama_paket;
        document.getElementById('m_kategori_layanan').value = paket.kategori_layanan;
        document.getElementById('m_metode_sunat').value = paket.metode_sunat;
        document.getElementById('m_harga').value = paket.harga;
        document.getElementById('m_nominal_dp').value = paket.nominal_dp;
        document.getElementById('m_deskripsi').value = paket.deskripsi || '';
        document.getElementById('m_keunggulan').value = paket.keunggulan || '';

        modal.classList.remove('hidden');
    }

    function closePaketModal() {
        modal.classList.add('hidden');
    }
</script>
@endpush