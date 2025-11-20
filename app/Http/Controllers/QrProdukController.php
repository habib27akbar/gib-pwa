<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absen;
use App\Models\Produk;
use App\Models\Kunjungan;
use App\Models\ItemCustomer;
use Illuminate\Http\Request;
use App\Models\JadwalTeknisi;
use App\Models\KomplainKunjungan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class QrProdukController extends Controller
{


    public function edit($id)
    {
        //$foto = Slider::all();
        //dd($sejarah);
        $produk = Produk::findOrFail($id);
        $item_customer = null;
        $data_unit = null;
        if (Auth::check()) {
            // var_dump($id);
            // exit;
            $item_customer = ItemCustomer::select('item_customer.id_lokasi', 'alamat_customer.alamat', 'item_customer.id')
                ->join('alamat_customer', 'alamat_customer.id', '=', 'item_customer.id_lokasi')
                ->where('item_customer.id_customer', Auth::user()->id_customer)
                ->where('item_customer.id_produk', $id)
                ->groupBy('item_customer.id_lokasi', 'alamat_customer.alamat', 'item_customer.id')
                ->get();
            $data_unit = [];

            //var_dump($item_customer);
            foreach ($item_customer as $item) {

                // Ambil semua unit yang terkait dengan item_customer ini
                $units = DB::table('unit')
                    ->select('unit.id as id_unit', 'unit.serial_number', 'unit.tgl_pembelian')
                    ->where('unit.id_item_customer', $item->id)
                    ->get();

                // Push data
                $data_unit[] = [
                    'id_lokasi' => $item->id_lokasi,
                    'alamat'    => $item->alamat,
                    'unit'      => $units
                ];
            }
        }
        //echo "AAAA";
        $layout = Auth::check() ? 'layouts.master' : 'layouts.welcome';
        return view('qr_produk.edit', compact('produk', 'data_unit', 'layout'));
    }

    public function editCustom($param)
    {
        list($id_customer, $id_produk, $id_lokasi, $nomor_urut_unit) = explode('-', $param);

        $produk = Produk::findOrFail($id_produk);
        $item_customer = null;
        $data_unit = null;

        if (Auth::check()) {
            $item_customer = ItemCustomer::select('item_customer.id_lokasi', 'alamat_customer.alamat', 'item_customer.id', 'item_customer.id_produk', 'item_customer.id_customer')
                ->join('alamat_customer', 'alamat_customer.id', '=', 'item_customer.id_lokasi')
                ->where('item_customer.id_customer', Auth::user()->id_customer)
                ->where('item_customer.id_produk', $id_produk)
                ->where('item_customer.id_lokasi', $id_lokasi)
                // ->groupBy('item_customer.id_lokasi', 'alamat_customer.alamat', 'item_customer.id')
                ->get();
            //echo "AAAAA";

            if (!empty($_GET['hbb'])) {
                var_dump($item_customer);
                //var_dump(Auth::user()->id_customer);
                echo "<br/>";
            }
            $data_unit = [];
            foreach ($item_customer as $item) {

                $units = DB::table('unit')
                    ->select('unit.id as id_unit', 'unit.serial_number', 'unit.sn', 'unit.tgl_pembelian', 'unit.keterangan', 'unit.id_produk', 'unit.id_lokasi', 'unit.id_customer')
                    ->where('unit.id_item_customer', $item->id)
                    ->where('unit.id_customer', $item->id_customer)
                    ->where('unit.id_produk', $item->id_produk)
                    ->where('unit.id_lokasi', $item->id_lokasi)
                    ->get();
                if (!empty($_GET['cekquery'])) {
                    var_dump($item->id);
                    var_dump($item->id_customer);
                    var_dump($item->id_produk);
                    var_dump($item->id_lokasi);
                    // $query = DB::table('unit')
                    //     ->select('unit.id as id_unit', 'unit.serial_number', 'unit.sn', 'unit.tgl_pembelian', 'unit.keterangan', 'unit.id_produk', 'unit.id_lokasi', 'unit.id_customer')
                    //     ->where('unit.id_item_customer', $item->id)
                    //     ->where('unit.id_customer', $item->id_customer)
                    //     ->where('unit.id_produk', $item->id_produk)
                    //     ->where('unit.id_lokasi', $item->id_lokasi);
                    // dd($query->toSql(), $query->getBindings());
                }
                // var_dump($units);
                // exit;

                $data_unit[] = [
                    'id_lokasi' => $item->id_lokasi,
                    'alamat'    => $item->alamat,
                    'unit'      => $units
                ];
            }
        }
        $layout = Auth::check() ? 'layouts.master' : 'layouts.welcome';
        return view('qr_produk.edit', compact('produk', 'data_unit', 'param', 'layout', 'id_customer', 'id_lokasi', 'id_produk'));
    }
}
