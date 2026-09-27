@extends('layouts.admin')

@section('title', 'Master Tenaga Medis / Dokter')
@section('page_title', 'Manajemen Tenaga Medis & Dokter')
@section('page_subtitle', 'Data dokter operator sirkumsisi, jadwal praktik, dan status keaktifan tugas')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($dokters as $dok)
    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between">
        <div>
            <div class="flex justify-between items-start mb-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center text-3xl shadow-sm">
                    <i class="bi bi-person-fill"></i>
                </div>
                <a href="{{ route('admin.dokter.toggle', $dok->id) }}" class="px-3 py-1 rounded-full text-xs font-bold uppercase transition {{ $dok->status === 'aktif' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                    {{ $dok->status === 'aktif' ? 'Aktif Bertugas' : 'Cuti' }}
                </a>
            </div>

            <h3 class="text-base font-extrabold text-slate-900 mb-1">{{ $dok->nama_dokter }}</h3>
            <p class="text-xs text-emerald-600 font-semibold mb-3">{{ $dok->spesialisasi }}</p>

            <div class="p-3 bg-slate-50 rounded-xl space-y-1.5 text-xs text-slate-600 border border-slate-100">
                <div class="flex items-center">
                    <i class="bi bi-telephone text-slate-400 mr-2"></i>
                    <span>{{ $dok->no_hp }}</span>
                </div>
                <div class="flex items-center">
                    <i class="bi bi-calendar3 text-slate-400 mr-2"></i>
                    <span>{{ $dok->hari_praktik }}</span>
                </div>
                <div class="flex items-center">
                    <i class="bi bi-clock text-slate-400 mr-2"></i>
                    <span>{{ $dok->jam_praktik }}</span>
                </div>
            </div>
        </div>

        <div class="pt-4 mt-4 border-t border-slate-100 flex justify-end">
            <a href="{{ route('admin.dokter.toggle', $dok->id) }}" class="text-xs font-bold text-slate-500 hover:text-emerald-600">
                <i class="bi bi-arrow-repeat mr-1"></i> Ubah Status Tugas
            </a>
        </div>
    </div>
    @endforeach
</div>
@endsection