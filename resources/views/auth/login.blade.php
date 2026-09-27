@extends('layouts.app')

@section('title', 'Portal Login Staf Pelayanan - Rumah Sunat Elnara')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8 bg-slate-100">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-2xl border border-slate-200 p-8 sm:p-10">
        <div class="text-center mb-8">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center text-3xl mx-auto mb-4 shadow-lg shadow-emerald-500/20">
                <i class="bi bi-shield-lock-fill"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Portal Staf Terpadu</h2>
            <p class="text-xs text-slate-500 mt-1">Masuk untuk mengelola pendaftaran, antrean, dan rekam medis</p>
        </div>

        @if($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl mb-6 text-xs text-rose-700">
            <ul class="list-disc pl-4 space-y-1">
                @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Username</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                        <i class="bi bi-person"></i>
                    </span>
                    <input type="text" name="username" required value="{{ old('username') }}" placeholder="Masukkan username staf" class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                        <i class="bi bi-key"></i>
                    </span>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm transition">
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-extrabold rounded-xl shadow-lg shadow-emerald-600/30 text-sm transition transform hover:-translate-y-0.5">
                    <i class="bi bi-box-arrow-in-right mr-1.5"></i> Masuk ke Panel Sistem
                </button>
            </div>
        </form>

        <!-- Demo Accounts Help Box -->
        <div class="mt-8 pt-6 border-t border-slate-100">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-3 text-center">Akun Demo Pengujian Sistem:</span>
            <div class="grid grid-cols-3 gap-2 text-[11px] text-center">
                <div class="p-2 bg-slate-50 rounded-xl border border-slate-200">
                    <span class="font-bold text-emerald-700 block">Admin</span>
                    <span class="text-slate-500 block">admin</span>
                    <span class="text-slate-400 block font-mono">admin123</span>
                </div>
                <div class="p-2 bg-slate-50 rounded-xl border border-slate-200">
                    <span class="font-bold text-blue-700 block">Dokter</span>
                    <span class="text-slate-500 block">dr_rizky</span>
                    <span class="text-slate-400 block font-mono">dokter123</span>
                </div>
                <div class="p-2 bg-slate-50 rounded-xl border border-slate-200">
                    <span class="font-bold text-amber-700 block">Pimpinan</span>
                    <span class="text-slate-500 block">pimpinan</span>
                    <span class="text-slate-400 block font-mono">pimpinan123</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection