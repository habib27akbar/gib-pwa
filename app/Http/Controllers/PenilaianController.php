<?php

namespace App\Http\Controllers;

use App\Models\Koordinasi;
use App\Models\KomplainKunjungan;
use App\Models\Penilaian;
use Illuminate\Http\Request;


class PenilaianController extends Controller
{
    public function index()
    {
        return redirect('komplain');
    }
    public function edit($id)
    {
        //$foto = Slider::all();
        //dd($sejarah);
        // $komplain = KomplainKunjungan::findOrFail($id);
        // $item = ItemCustomer::select('item_customer.id', 'item_customer.id_produk', 'produk.judul')
        //     ->join('produk', 'produk.id_produk', '=', 'item_customer.id_produk')
        //     ->where('item_customer.id_lokasi', $komplain->id_lokasi)->get();
        // // var_dump($item);
        // // exit;
        // $unit = Unit::select('id', 'id_item_customer', 'serial_number', 'tgl_pembelian')
        //     ->where('id_item_customer', $komplain->id_item)->get();

        //$kunjungan  = KomplainKunjungan::findOrFail($id);

        $kunjungan = KomplainKunjungan::query()

            ->join('users', 'users.id', '=', 'komplain_kunjungan.user_id')
            ->join('customer', 'customer.id', '=', 'users.id_customer')
            ->join('item_customer', 'item_customer.id', '=', 'komplain_kunjungan.id_item')
            ->join('produk', 'produk.id_produk', '=', 'item_customer.id_produk')
            ->join('alamat_customer', 'alamat_customer.id', '=', 'komplain_kunjungan.id_lokasi')
            ->join('unit', 'unit.id', '=', 'komplain_kunjungan.id_unit')
            ->select(
                'komplain_kunjungan.id',
                'users.nama_lengkap',
                'users.email',
                'users.no_telp',
                'customer.nama_customer',
                'alamat_customer.alamat',
                'komplain_kunjungan.pesan',
                'komplain_kunjungan.tgl_kunjungan',
                'komplain_kunjungan.jam',
                'komplain_kunjungan.gambar',
                'komplain_kunjungan.created_at'
            )
            ->where('komplain_kunjungan.id', $id)
            ->firstOrFail();

        //$absensi =  Absen::where('id_kunjungan', $id)->where('user_id', auth()->id())->get();

        $koordinasi = Koordinasi::join('users', 'users.id', '=', 'koordinasi.id_user')
            ->where('koordinasi.id_komplain_kunjungan', $id)->get(['koordinasi.*', 'users.nama_lengkap']);

        return view('penilaian.edit', compact('kunjungan', 'koordinasi'));
        //return view('komplain.edit', compact('komplain', 'item', 'unit'));
    }

    public function update(Request $request, $id)
    {


        Penilaian::where('id_komplain_kunjungan', $id)->delete();




        $storeData = [

            'id_komplain_kunjungan' => $id,
            'bintang' => $request->input('rating'),
            'catatan' => $request->input('catatan')
        ];

        Penilaian::create($storeData);
        return redirect('komplain')->with('alert-success', 'Success Memberikan Penilaian');
    }
}
