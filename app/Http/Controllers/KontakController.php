<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Identitas;
use App\Models\ModAlamat;

class KontakController extends Controller
{


    public function index()
    {
        $identitas = Identitas::first(); // Ambil baris pertama dari tabel identitas
        $alamat = ModAlamat::first();
        return view('kontak.index', compact('identitas', 'alamat'));
    }
}
