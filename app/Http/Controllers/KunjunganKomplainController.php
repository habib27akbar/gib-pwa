<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absen;
use App\Models\Kunjungan;
use App\Models\Koordinasi;
use Illuminate\Http\Request;
use App\Models\JadwalTeknisi;
use App\Models\KomplainKunjungan;
use App\Models\LaporanKomplainTeknisi;
use Illuminate\Support\Facades\Auth;

class KunjunganKomplainController extends Controller
{
    //
    public function index()
    {

        return view('kunjungan_komplain.index');
    }

    public function create()
    {
        $laporan = LaporanKomplainTeknisi::where('id_teknisi', Auth::user()->id)->where('id_komplain', request()->get('id_kunjungan'))->first();
        //var_dump(Auth::user()->id);
        return view('kunjungan_komplain.create', compact('laporan'));
    }



    public function edit($id)
    {
        //$foto = Slider::all();
        //dd($sejarah);
        $kunjungan = JadwalTeknisi::query()
            ->join('komplain_kunjungan', 'komplain_kunjungan.id', '=', 'jadwal_teknisi.id_komplain_kunjungan')
            ->join('users', 'users.id', '=', 'komplain_kunjungan.user_id')
            ->join('customer', 'customer.id', '=', 'users.id_customer')
            ->join('item_customer', 'item_customer.id', '=', 'komplain_kunjungan.id_item')
            ->join('produk', 'produk.id_produk', '=', 'item_customer.id_produk')
            ->join('alamat_customer', 'alamat_customer.id', '=', 'komplain_kunjungan.id_lokasi')
            ->join('unit', 'unit.id', '=', 'komplain_kunjungan.id_unit')
            ->select(
                'jadwal_teknisi.id_komplain_kunjungan',
                'users.nama_lengkap',
                'users.email',
                'users.no_telp',
                'customer.nama_customer',
                'alamat_customer.alamat',
                'komplain_kunjungan.pesan',
                'komplain_kunjungan.tgl_kunjungan',
                'komplain_kunjungan.jam',
                'komplain_kunjungan.gambar',
                'komplain_kunjungan.sts',
                'komplain_kunjungan.created_at'
            )
            ->where('komplain_kunjungan.id', $id)
            ->firstOrFail();

        $absensi =  Absen::where('id_kunjungan', $id)->where('user_id', auth()->id())->get();

        $koordinasi = Koordinasi::join('users', 'users.id', '=', 'koordinasi.id_user')
            ->where('koordinasi.id_komplain_kunjungan', $id)->get(['koordinasi.*', 'users.nama_lengkap']);

        return view('kunjungan_komplain.edit', compact('kunjungan', 'absensi', 'koordinasi'));
    }

    public function show($id)
    {
        //$foto = Slider::all();
        //dd($sejarah);
        $kunjungan = KomplainKunjungan::findOrFail($id);

        return view('kunjungan_komplain.view', compact('kunjungan'));
    }

    public function store(Request $request)
    {
        if ($request->teknisi == 'true') {
            $laporan = LaporanKomplainTeknisi::where('id_teknisi', Auth::user()->id)->where('id_komplain', $request->input('id_komplain'))->first();
            $nama_image = $request->gambar_old;
            if ($request->file('gambar')) {
                $image = $request->file('gambar');
                $nama_image = 'gambar-' . uniqid() . '-' . $image->getClientOriginalName();
                $dir = 'img/kunjungan';
                $image->move(public_path($dir), $nama_image);
            }
            if ($laporan) {
                $laporan->update([
                    'tanggal' => $request->input('tanggal'),
                    'id_komplain' => $request->input('id_komplain'),
                    'id_unit' => $request->input('id_unit'),
                    'id_produk' => $request->input('id_produk'),
                    'id_customer' => $request->input('id_customer'),
                    'id_lokasi' => $request->input('id_lokasi'),
                    'catatan' => $request->input('catatan'),
                    'gambar' => $nama_image,
                    'id_teknisi' => Auth::user()->id
                ]);
                return redirect('kunjungan_komplain')->with('alert-success', 'Success Ubah Laporan');
            } else {
                $storeData = [

                    'tanggal' => $request->input('tanggal'),
                    'id_komplain' => $request->input('id_komplain'),
                    'id_unit' => $request->input('id_unit'),
                    'id_produk' => $request->input('id_produk'),
                    'id_customer' => $request->input('id_customer'),
                    'id_lokasi' => $request->input('id_lokasi'),
                    'catatan' => $request->input('catatan'),
                    'gambar' => $nama_image,
                    'id_teknisi' => Auth::user()->id,
                    'sts' => 0,
                ];
                LaporanKomplainTeknisi::create($storeData);
                return redirect('kunjungan_komplain')->with('alert-success', 'Success Membuat Laporan');
            }
        } else {
            $nama_image = null;
            if ($request->file('gambar')) {
                $image = $request->file('gambar');
                $nama_image = 'gambar-' . uniqid() . '-' . $image->getClientOriginalName();
                $dir = 'img/kunjungan';
                $image->move(public_path($dir), $nama_image);
            }

            $nama_image_galeri = null;
            if ($request->file('gambar_galeri')) {
                $image_galeri = $request->file('gambar_galeri');
                $nama_image_galeri = 'gambar_galeri-' . uniqid() . '-' . $image_galeri->getClientOriginalName();
                $dir = 'img/kunjungan';
                $image_galeri->move(public_path($dir), $nama_image_galeri);
            }

            $storeData = [
                'user_id' => auth()->id(),
                'catatan' => $request->input('catatan'),
                'alamat' => $request->input('alamat'),
                'longitude' => $request->input('longitude'),
                'latitude' => $request->input('latitude'),
                'gambar' => $nama_image,
                'gambar_galeri' => $nama_image_galeri,
                'sts' => 0,
            ];
            Kunjungan::create($storeData);
            return redirect('kunjungan_komplain')->with('alert-success', 'Success Tambah Data');
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->input('delete')) {
            $updateData = [
                'hapus' => 1
            ];
            Koordinasi::where('id', $request->input('id_chat'))->update($updateData);
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
        }
        return redirect()->route('kunjungan_komplain.edit', $id);
    }

    public function absen(Request $request, $id)
    {

        $nama_image = $request->input('gambar_old');
        if ($request->file('gambar')) {
            $image = $request->file('gambar');
            $nama_image = 'gambar-' . uniqid() . '-' . $image->getClientOriginalName();
            $dir = 'img/absensi';
            $image->move(public_path($dir), $nama_image);
        }



        $storeData = [
            'user_id' => auth()->id(),
            'id_kunjungan' => $id,
            'longitude' => $request->input('longitude'),
            'latitude' => $request->input('latitude'),
            'gambar' => $nama_image,

        ];
        Absen::create($storeData);
        return redirect('kunjungan_komplain')->with('alert-success', 'Success Update Data');
    }

    public function destroy($id)
    {
        Kunjungan::findOrFail($id)->delete();
        return redirect('kunjungan_komplain')->with('alert-success', 'Success deleted data');
    }



    public function getKunjungan(Request $request)
    {
        $sort = $request->query('sort', 'newest'); // Default sort: newest

        $query = JadwalTeknisi::query()

            ->join('komplain_kunjungan', 'komplain_kunjungan.id', '=', 'jadwal_teknisi.id_komplain_kunjungan')
            ->join('users', 'users.id', '=', 'komplain_kunjungan.user_id')
            ->join('customer', 'customer.id', '=', 'users.id_customer')
            ->join('item_customer', 'item_customer.id', '=', 'komplain_kunjungan.id_item')
            ->join('produk', 'produk.id_produk', '=', 'item_customer.id_produk')
            ->join('alamat_customer', 'alamat_customer.id', '=', 'komplain_kunjungan.id_lokasi')
            ->join('unit', 'unit.id', '=', 'komplain_kunjungan.id_unit')
            ->where('jadwal_teknisi.id_user', auth()->id())
            ->where('komplain_kunjungan.type', 'komplain')
            ->select('jadwal_teknisi.id_komplain_kunjungan', 'users.nama_lengkap', 'users.email', 'users.no_telp', 'customer.nama_customer', 'alamat_customer.alamat', 'komplain_kunjungan.pesan', 'komplain_kunjungan.updated_at', 'komplain_kunjungan.created_at', 'komplain_kunjungan.id', 'komplain_kunjungan.tgl_kunjungan', 'komplain_kunjungan.jam', 'komplain_kunjungan.gambar', 'komplain_kunjungan.gambar_galeri', 'komplain_kunjungan.sts', 'komplain_kunjungan.id_lokasi', 'komplain_kunjungan.id_unit', 'customer.id as id_customer')
            ->addSelect([
                'id_kunjungan_absen' => Absen::select('id_kunjungan')
                    ->whereColumn('absen.id_kunjungan', 'jadwal_teknisi.id_komplain_kunjungan')
                    ->latest('created_at')
                    ->limit(1),
                'laporan_komplain' => LaporanKomplainTeknisi::select('id')
                    ->whereColumn('laporan_komplain_teknisi.id_komplain', 'jadwal_teknisi.id_komplain_kunjungan')
                    ->where('id_teknisi', Auth::user()->id)
                    ->limit(1)
            ]);
        //dd($query->toSql());
        if ($request->has('search') && !empty($request->search)) {
            $search = strtolower($request->search); // Konversi ke huruf kecil untuk pencarian tidak case-sensitive
            $query->whereRaw('LOWER(komplain_kunjungan.pesan) LIKE ?', ["%{$search}%"]);
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
