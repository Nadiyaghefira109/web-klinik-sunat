<?php

namespace App\Http\Controllers;

use App\Models\PaketSunat;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->query('kategori');
        $query = PaketSunat::where('is_active', 1);

        if ($kategori && in_array($kategori, ['anak', 'rumah', 'premium', 'dewasa', 'bayi'])) {
            $query->where('kategori_layanan', $kategori);
        }

        $pakets = $query->orderBy('id', 'asc')->get();

        return view('public.paket', compact('pakets', 'kategori'));
    }
}
