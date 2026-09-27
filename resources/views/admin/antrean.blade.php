@extends('layouts.admin')

@section('title', 'Panggilan Antrean Pasien')
@section('page_title', 'Panggilan Antrean Realtime')
@section('page_subtitle', 'Panggil nomor antrean pasien ke ruang tindakan hari ini')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- Antrean Table -->
    <div class="lg:col-span-8 bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <div>
                <h3 class="text-base font-extrabold text-slate-900">Daftar Antrean Hari Ini</h3>
                <p class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($today)->translatedFormat('l, d F Y') }}</p>
            </div>
            <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full">
                Total: {{ $antreans->count() }} Pasien
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 uppercase font-bold border-b border-slate-200/60">
                        <th class="p-4 pl-6">Antrean</th>
                        <th class="p-4">Pasien & Wali</th>
                        <th class="p-4">Paket Khitan</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 pr-6 text-center">Aksi Panggilan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($antreans as $ant)
                    <tr class="hover:bg-slate-50/80 transition {{ $ant->status_pelayanan === 'tindakan' ? 'bg-amber-50/50' : '' }}">
                        <td class="p-4 pl-6 font-mono font-black text-emerald-700 text-lg">
                            {{ $ant->no_antrean }}
                        </td>
                        <td class="p-4">
                            <span class="font-bold text-slate-900 block text-sm">{{ $ant->pasien->nama_pasien }}</span>
                            <span class="text-slate-500 text-xs">{{ $ant->pasien->nama_ortu_wali }}</span>
                        </td>
                        <td class="p-4 text-slate-600">
                            {{ $ant->paket->nama_paket }}
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 text-xs font-bold uppercase rounded-full {{ $ant->status_pelayanan === 'tindakan' ? 'bg-amber-100 text-amber-800' : ($ant->status_pelayanan === 'selesai' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700') }}">
                                {{ $ant->status_pelayanan }}
                            </span>
                        </td>
                        <td class="p-4 pr-6 text-center">
                            <div class="flex justify-center space-x-2">
                                <!-- Tombol Suara Web Speech API -->
                                <button type="button" onclick="speakQueue('{{ $ant->no_antrean }}', '{{ $ant->pasien->nama_pasien }}')" class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded-xl transition text-sm shadow-xs" title="Panggil dengan Suara">
                                    <i class="bi bi-volume-up-fill"></i>
                                </button>

                                @if($ant->status_pelayanan !== 'tindakan' && $ant->status_pelayanan !== 'selesai')
                                <a href="{{ route('admin.antrean.panggil', $ant->id) }}" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-xs transition">
                                    Set Masuk
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-400">Belum ada pasien antrean hari ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Audio Call Panel -->
    <div class="lg:col-span-4 space-y-6">
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl p-6 text-white shadow-xl">
            <h3 class="font-bold text-base mb-2 flex items-center">
                <i class="bi bi-megaphone-fill text-amber-400 mr-2"></i> Panggilan Suara Otomatis
            </h3>
            <p class="text-xs text-slate-400 leading-relaxed mb-6">
                Sistem menggunakan teknologi Web Speech Synthesis bahasa Indonesia untuk memanggil nomor antrean langsung ke speaker ruang tunggu.
            </p>

            <div class="p-4 bg-slate-950/60 rounded-2xl border border-slate-700 space-y-3">
                <span class="text-xs font-bold text-slate-400 block uppercase">Tes Suara Antrean</span>
                <button type="button" onclick="speakQueue('A-01', 'Ananda Jagoan')" class="w-full py-2.5 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold rounded-xl text-xs transition">
                    <i class="bi bi-play-circle mr-1.5"></i> Tes Panggilan Audio
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function speakQueue(noAntrean, namaPasien) {
        if ('speechSynthesis' in window) {
            const text = `Nomor antrean, ${noAntrean}, atas nama, ${namaPasien}, silakan menuju ke ruang tindakan dokter.`;
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'id-ID';
            utterance.rate = 0.9;
            window.speechSynthesis.speak(utterance);
        } else {
            Swal.fire('Info', 'Browser Anda tidak mendukung Web Speech Audio.', 'info');
        }
    }
</script>
@endpush