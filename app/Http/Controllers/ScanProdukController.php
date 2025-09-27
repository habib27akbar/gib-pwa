<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;


class ScanProdukController extends Controller
{
    public function index()
    {
        $layout = Auth::check() ? 'layouts.master' : 'layouts.welcome';
        return view('scan_produk.index', compact('layout'));
    }
}
