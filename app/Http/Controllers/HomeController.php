<?php

namespace App\Http\Controllers;

use App\Models\PaketSunat;
use App\Models\Dokter;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $pakets = PaketSunat::where('is_active', 1)->get();
        $dokters = Dokter::where('status', 'aktif')->get();
        $totalPasien = Pendaftaran::where('status_pelayanan', 'selesai')->count() + 120; // baseline

        return view('public.home', compact('pakets', 'dokters', 'totalPasien'));
    }

    public function edukasi()
    {
        return view('public.edukasi');
    }
}
