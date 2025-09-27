<?php

namespace App\Http\Controllers;

use App\Models\UlasanProduk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    //
    public function index()
    {

        return view('produk.index');
    }

    public function ulasan(Request $request)
    {

        $ulasan = UlasanProduk::where('id_produk', $request->input('id_produk'))
            ->where('id_customer', $request->input('id_customer'))
            ->where('id_lokasi', $request->input('id_lokasi'))
            ->first();
        $storeData = [

            'id_customer' => $request->input('id_customer'),
            'id_produk' => $request->input('id_produk'),
            'id_lokasi' => $request->input('id_lokasi'),
            'ulasan' => $request->input('ulasan_produk'),
            'bintang' => $request->input('rating'),
            'status' => 0
        ];
        // var_dump($storeData);
        if ($ulasan) {
            UlasanProduk::where('id', $ulasan->id)->update($storeData);
        } else {
            UlasanProduk::create($storeData);
        }
        echo "ok";
    }
}
