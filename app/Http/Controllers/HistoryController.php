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
use App\Models\KunjunganRutin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{


    public function show(Request $request, $id_produk, $id_lokasi)
    {
        //$foto = Slider::all();
        //dd(Auth::user()->id);
        $produk = Produk::findOrFail($id_produk);

        $komplain = KomplainKunjungan::with(['jadwalTeknisi.user']) // eager load teknisi dan nama user
            ->select(
                'komplain_kunjungan.pesan',
                'komplain_kunjungan.created_at',
                'komplain_kunjungan.sts',
                'komplain_kunjungan.tgl_kunjungan',
                'komplain_kunjungan.id',
                'item_customer.id_produk'
            )
            ->join('item_customer', 'item_customer.id', '=', 'komplain_kunjungan.id_item')
            ->join('produk', 'produk.id_produk', '=', 'item_customer.id_produk')
            ->where('komplain_kunjungan.user_id', Auth::user()->id)
            ->where('komplain_kunjungan.id_lokasi', $id_lokasi)
            ->where('komplain_kunjungan.id_unit', $request->get('id_unit'))
            //->where('item_customer.id_produk', $id_produk)
            ->orderBy('komplain_kunjungan.created_at', 'DESC')
            ->get();


        // $kunjungan_rutin = KunjunganRutin::select('*')
        //     ->where('id_customer', Auth::user()->id_customer)
        //     ->where('id_lokasi', $id_lokasi)
        //     ->orderBy('kunjungan_rutin.created_at', 'DESC')
        //     ->get();

        $kunjunganRutinList = KunjunganRutin::with(['teknisis.user'])->get();

        $result = [];

        foreach ($kunjunganRutinList as $rutin) {
            if ($request->get('param') == $rutin->serial_number) {
                # code...

                // echo $rutin;
                // echo "<br/>";
                // echo "<br/>";
                $start = Carbon::parse($rutin->tgl_mulai);
                $end = Carbon::parse($rutin->tgl_selesai);

                $tanggalList = [];

                for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                    $teknisiHarian = $rutin->teknisis->filter(function ($tek) use ($date) {
                        return $tek->tanggal === $date->toDateString() && !empty($tek->catatan);
                    });

                    // Hanya tambahkan ke list jika ada teknisi dengan catatan
                    if ($teknisiHarian->isNotEmpty()) {
                        $tanggalList[] = [
                            'tanggal' => $date->toDateString(),
                            'teknisi' => $teknisiHarian
                        ];
                    }
                }


                $result[] = [
                    'id_customer' => $rutin->id_customer,
                    'id_lokasi' => $rutin->id_lokasi,
                    'user_id' => $rutin->user_id,
                    'catatan' => $rutin->catatan,
                    'tanggal' => $tanggalList
                ];

                //dd($komplain);
            }
        }
        return view('history.view', compact('produk', 'komplain', 'result'));
    }
}
