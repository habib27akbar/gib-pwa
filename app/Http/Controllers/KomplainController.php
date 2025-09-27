<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Unit;
use App\Models\Komplain;
use App\Models\Koordinasi;
use App\Models\ItemCustomer;
use Illuminate\Http\Request;
use App\Models\KomplainKunjungan;

class KomplainController extends Controller
{
    //
    public function index()
    {

        return view('komplain.index');
    }

    public function create()
    {

        return view('komplain.create');
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
                'komplain_kunjungan.created_at',
                'komplain_kunjungan.sts'
            )
            ->where('komplain_kunjungan.id', $id)
            ->firstOrFail();

        //$absensi =  Absen::where('id_kunjungan', $id)->where('user_id', auth()->id())->get();

        $koordinasi = Koordinasi::join('users', 'users.id', '=', 'koordinasi.id_user')
            ->where('koordinasi.id_komplain_kunjungan', $id)->get(['koordinasi.*', 'users.nama_lengkap']);

        return view('komplain.edit', compact('kunjungan', 'koordinasi'));
        //return view('komplain.edit', compact('komplain', 'item', 'unit'));
    }

    public function store(Request $request)
    {
        $nama_image = null;
        if ($request->file('gambar')) {
            $image = $request->file('gambar');
            $nama_image = 'gambar-' . uniqid() . '-' . $image->getClientOriginalName();
            $dir = 'img/komplain';
            $image->move(public_path($dir), $nama_image);
        }

        $nama_image_galeri = null;
        if ($request->file('gambar_galeri')) {
            $image_galeri = $request->file('gambar_galeri');
            $nama_image_galeri = 'gambar_galeri-' . uniqid() . '-' . $image_galeri->getClientOriginalName();
            $dir = 'img/komplain';
            $image_galeri->move(public_path($dir), $nama_image_galeri);
        }

        $id_item = $request->input('id_item');
        if (!$id_item) {
            $item_customer = ItemCustomer::where('id_customer', $request->id_customer)
                ->where('id_produk', $request->id_produk)
                ->where('id_lokasi', $request->id_lokasi)
                ->firstOrFail();

            $id_item = $item_customer->id;
        }

        $storeData = [
            'user_id' => auth()->id(),
            'id_item' => $id_item,
            'id_lokasi' => $request->input('id_lokasi'),
            'id_unit' => $request->input('id_unit'),
            'pesan' => $request->input('pesan'),
            'gambar' => $nama_image,
            'gambar_galeri' => $nama_image_galeri,
            'type' => 'komplain',
            'sts' => 0,
        ];
        KomplainKunjungan::create($storeData);
        return redirect('komplain')->with('alert-success', 'Success Tambah Data');
    }

    public function update(Request $request, $id)
    {

        // $nama_image = $request->input('gambar_old');
        // if ($request->file('gambar')) {
        //     $image = $request->file('gambar');
        //     $nama_image = 'gambar-' . uniqid() . '-' . $image->getClientOriginalName();
        //     $dir = 'img/komplain';
        //     $image->move(public_path($dir), $nama_image);
        // }

        // $nama_image_galeri = $request->input('gambar_galeri_old');
        // if ($request->file('gambar_galeri')) {
        //     $image_galeri = $request->file('gambar_galeri');
        //     $nama_image_galeri = 'gambar_galeri-' . uniqid() . '-' . $image_galeri->getClientOriginalName();
        //     $dir = 'img/komplain';
        //     $image_galeri->move(public_path($dir), $nama_image_galeri);
        // }

        // $updateData = [
        //     'user_id' => auth()->id(),
        //     'id_item' => $request->input('id_item'),
        //     'id_lokasi' => $request->input('id_lokasi'),
        //     'id_unit' => $request->input('id_unit'),
        //     'pesan' => $request->input('pesan'),
        //     'gambar' => $nama_image,
        //     'gambar_galeri' => $nama_image_galeri,
        //     'type' => 'komplain',
        // ];
        // KomplainKunjungan::where('id', $id)->update($updateData);
        // return redirect('komplain')->with('alert-success', 'Success Update Data');

        if ($request->input('delete')) {
            $updateData = [
                'hapus' => 1
            ];
            Koordinasi::where('id', $request->input('id_chat'))->update($updateData);
            return redirect()->route('komplain.edit', $id);
        } elseif ($request->input('update_sts')) {
            $updateData = [
                'sts' => 1
            ];
            KomplainKunjungan::where('id', $id)->update($updateData);
            return redirect()->route('penilaian.edit', $id);
        } else {
            $nama_image = null;
            if ($request->file('gambar')) {
                $image = $request->file('gambar');
                $nama_image = 'gambar-' . uniqid() . '-' . $image->getClientOriginalName();
                $dir = 'img/komplain';
                $image->move(public_path($dir), $nama_image);
            }



            $storeData = [
                'id_user' => auth()->id(),
                'id_komplain_kunjungan' => $id,
                'catatan' => $request->input('message'),
                'gambar' => $nama_image
            ];

            Koordinasi::create($storeData);
            return redirect()->route('komplain.edit', $id);
        }
    }

    public function destroy($id)
    {
        KomplainKunjungan::findOrFail($id)->delete();
        return redirect('komplain')->with('alert-success', 'Success deleted data');
    }

    public function getKomplain(Request $request)
    {
        $sort = $request->query('sort', 'newest'); // Default sort: newest

        // $query = KomplainKunjungan::query()
        //     ->where('user_id', auth()->id())
        //     ->where('type', 'komplain');

        $query = KomplainKunjungan::query()
            ->join('item_customer', 'item_customer.id', '=', 'komplain_kunjungan.id_item')
            ->join('produk', 'produk.id_produk', '=', 'item_customer.id_produk')
            ->join('alamat_customer', 'alamat_customer.id', '=', 'komplain_kunjungan.id_lokasi')
            ->join('unit', 'unit.id', '=', 'komplain_kunjungan.id_unit')
            ->select('komplain_kunjungan.*', 'item_customer.id_produk', 'produk.judul', 'alamat_customer.alamat', 'unit.serial_number', 'unit.tgl_pembelian') // sesuaikan kolom yang dibutuhkan
            ->where('komplain_kunjungan.user_id', auth()->id())
            ->where('komplain_kunjungan.type', 'komplain');

        if ($request->has('search') && !empty($request->search)) {
            $search = strtolower($request->search); // Konversi ke huruf kecil untuk pencarian tidak case-sensitive
            $query->whereRaw('LOWER(pesan) LIKE ?', ["%{$search}%"]);
        }

        if ($sort === 'oldest') {
            $query->orderByRaw('COALESCE(komplain_kunjungan.updated_at, komplain_kunjungan.created_at) ASC');
        } elseif ($sort === 'newest') {
            $query->orderByRaw('COALESCE(komplain_kunjungan.updated_at, komplain_kunjungan.created_at) DESC');
        } else {
            $query->orderBy('komplain_kunjungan.created_at', 'desc');
        }

        $komplain = $query->paginate(10); // 6 data per halaman

        // Format tanggal tanpa menghilangkan pagination
        $komplain->getCollection()->map(function ($item) {
            $item->created_at_formatted = Carbon::parse($item->created_at)->format('d M Y H:i');
            if ($item->updated_at) {
                $item->updated_at_formatted = Carbon::parse($item->updated_at)->format('d M Y H:i');
            }

            return $item;
        });

        return response()->json($komplain);
    }
}
