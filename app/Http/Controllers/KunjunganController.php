<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\ItemCustomer;
use App\Models\JadwalTeknisi;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\KomplainKunjungan;
use App\Models\KunjunganTeknisi;
use Carbon\Carbon;

class KunjunganController extends Controller
{
    //
    public function index()
    {

        return view('kunjungan.index');
    }

    public function create()
    {

        return view('kunjungan.create');
    }

    public function edit($id)
    {
        //$foto = Slider::all();
        //dd($sejarah);
        $kunjungan = JadwalTeknisi::query()
            ->join('kunjungan_rutin', 'kunjungan_rutin.id', '=', 'jadwal_teknisi.id_komplain_kunjungan')
            ->join('customer', 'customer.id', '=', 'kunjungan_rutin.id_customer')
            ->join('users', 'users.id', '=', 'kunjungan_rutin.user_id')
            ->join('alamat_customer', 'alamat_customer.id', '=', 'kunjungan_rutin.id_lokasi')

            ->select(
                'jadwal_teknisi.id_komplain_kunjungan',
                'users.nama_lengkap',
                'users.email',
                'users.no_telp',
                'customer.nama_customer',
                'alamat_customer.alamat',
                'kunjungan_rutin.catatan',
                'kunjungan_rutin.tgl_mulai',
                'kunjungan_rutin.tgl_selesai',
                'kunjungan_rutin.id_lokasi',
                'kunjungan_rutin.id_produk',
                'kunjungan_rutin.serial_number'
            )
            ->addSelect([
                'gambar_absen' => Absen::select('gambar')
                    ->whereColumn('absen.id_kunjungan', 'kunjungan_rutin.id')
                    ->latest('created_at')
                    ->limit(1)
            ])
            ->where('kunjungan_rutin.id', $id)
            ->where('jadwal_teknisi.id_user', auth()->id())
            ->firstOrFail();

        $absensi =  Absen::where('id_kunjungan', $id)->where('user_id', auth()->id())->get();
        //dd($kunjungan->id_lokasi);
        $item_customer = ItemCustomer::join('produk', 'produk.id_produk', '=', 'item_customer.id_produk')
            ->where('item_customer.id_lokasi', $kunjungan->id_lokasi)
            ->get([
                'produk.id_produk',
                'produk.judul'
            ]);

        $kunjungan_teknisi = KunjunganTeknisi::join('produk', 'produk.id_produk', '=', 'kunjungan_teknisi.id_produk')
            ->join('users', 'users.id', '=', 'kunjungan_teknisi.id_teknisi')
            ->where('kunjungan_teknisi.id_teknisi', auth()->id())
            ->where('kunjungan_teknisi.id_kunjungan_rutin', $id)
            ->select('kunjungan_teknisi.*', 'produk.judul')->get();

        return view('kunjungan.edit', compact('kunjungan', 'absensi', 'item_customer', 'kunjungan_teknisi'));
    }

    public function show($id)
    {
        //$foto = Slider::all();
        //dd($sejarah);
        $kunjungan = KomplainKunjungan::findOrFail($id);

        return view('kunjungan.view', compact('kunjungan'));
    }

    public function store(Request $request)
    {
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

        // $storeData = [
        //     'user_id' => auth()->id(),
        //     'catatan' => $request->input('catatan'),
        //     'alamat' => $request->input('alamat'),
        //     'longitude' => $request->input('longitude'),
        //     'latitude' => $request->input('latitude'),
        //     'gambar' => $nama_image,
        //     'gambar_galeri' => $nama_image_galeri,
        //     'sts' => 0,
        // ];
        $storeData = [
            'id_teknisi' => auth()->id(),
            'tanggal' => $request->input('tanggal'),
            'catatan' => $request->input('catatan'),
            'id_produk' => $request->input('id_produk'),
            'serial_number' => $request->input('serial_number'),
            'gambar' => $nama_image,
            'status' => 1,
        ];
        KunjunganTeknisi::create($storeData);
        return redirect('kunjungan')->with('alert-success', 'Success Tambah Data');
    }

    public function update(Request $request, $id)
    {

        $nama_image = $request->input('gambar_old');
        if ($request->file('gambar')) {
            $image = $request->file('gambar');
            $nama_image = 'gambar-' . uniqid() . '-' . $image->getClientOriginalName();
            $dir = 'img/kunjungan';
            $image->move(public_path($dir), $nama_image);
        }

        // $nama_image_galeri = $request->input('gambar_galeri_old');
        // if ($request->file('gambar_galeri')) {
        //     $image_galeri = $request->file('gambar_galeri');
        //     $nama_image_galeri = 'gambar_galeri-' . uniqid() . '-' . $image_galeri->getClientOriginalName();
        //     $dir = 'img/kunjungan';
        //     $image_galeri->move(public_path($dir), $nama_image_galeri);
        // }
        //Absen::where('id_kunjungan', $id)->delete();

        // $storeData = [
        //     'user_id' => auth()->id(),
        //     'id_kunjungan' => $id,
        //     'catatan' => $request->input('catatan'),
        //     'longitude' => $request->input('longitude'),
        //     'latitude' => $request->input('latitude'),
        //     'gambar' => $nama_image
        // ];

        // Absen::create($storeData);

        $storeData = [
            'id_kunjungan_rutin' => $id,
            'id_teknisi' => auth()->id(),
            'id_produk' => $request->input('id_produk'),
            'serial_number' => $request->input('serial_number'),
            'tanggal' => $request->input('tanggal'),
            'catatan' => $request->input('catatan'),
            'gambar' => $nama_image,
            'status' => 1,
        ];
        // var_dump($request->input('id'));
        // var_dump($storeData);
        // exit;

        if ($request->input('id')) {
            KunjunganTeknisi::where('id',  $request->input('id'))->update($storeData);
        } else {
            KunjunganTeknisi::create($storeData);
        }
        //
        return redirect()->route('kunjungan.edit', $id)->with('alert-success', 'Sukses ubah data');
        // Kunjungan::where('id', $id)->update($updateData);
        //return redirect('kunjungan')->with('alert-success', 'Absen Success');
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
        return redirect('kunjungan')->with('alert-success', 'Success Update Data');
    }

    public function destroy($id)
    {
        Kunjungan::findOrFail($id)->delete();
        return redirect('kunjungan')->with('alert-success', 'Success deleted data');
    }



    public function getKunjungan(Request $request)
    {
        $sort = $request->query('sort', 'newest'); // Default sort: newest

        $query = JadwalTeknisi::query()

            ->join('kunjungan_rutin', 'kunjungan_rutin.id', '=', 'jadwal_teknisi.id_komplain_kunjungan')

            ->join('customer', 'customer.id', '=', 'kunjungan_rutin.id_customer')
            ->join('users', 'users.id_customer', '=', 'customer.id')
            ->join('alamat_customer', 'alamat_customer.id', '=', 'kunjungan_rutin.id_lokasi')

            ->where('jadwal_teknisi.id_user', auth()->id())

            ->select('jadwal_teknisi.id_komplain_kunjungan', 'users.nama_lengkap', 'users.email', 'users.no_telp', 'customer.nama_customer', 'alamat_customer.alamat', 'kunjungan_rutin.catatan', 'kunjungan_rutin.updated_at', 'kunjungan_rutin.created_at', 'kunjungan_rutin.id', 'kunjungan_rutin.tgl_mulai', 'kunjungan_rutin.tgl_selesai')
            ->addSelect([
                'id_kunjungan_absen' => Absen::select('id_kunjungan')
                    ->whereColumn('absen.id_kunjungan', 'jadwal_teknisi.id_komplain_kunjungan')
                    ->latest('created_at')
                    ->limit(1)
            ]);
        //dd($query->toSql());
        if ($request->has('search') && !empty($request->search)) {
            $search = strtolower($request->search); // Konversi ke huruf kecil untuk pencarian tidak case-sensitive
            $query->whereRaw('LOWER(kunjungan_rutin.catatan) LIKE ?', ["%{$search}%"])
                ->orWhereRaw('LOWER(users.nama_lengkap) LIKE ?', ["%{$search}%"])
                ->orWhereRaw('LOWER(users.email) LIKE ?', ["%{$search}%"])
                ->orWhereRaw('LOWER(users.no_telp) LIKE ?', ["%{$search}%"])
                ->orWhereRaw('LOWER(customer.nama_customer) LIKE ?', ["%{$search}%"])
                ->orWhereRaw('LOWER(alamat_customer.alamat) LIKE ?', ["%{$search}%"])
                ->orWhereRaw("DATE_FORMAT(kunjungan_rutin.tgl_mulai, '%d/%m/%Y') LIKE ?", ["%{$search}%"])
                ->orWhereRaw("DATE_FORMAT(kunjungan_rutin.tgl_selesai, '%d/%m/%Y') LIKE ?", ["%{$search}%"]);
        }

        // if ($request->has('search') && !empty($request->search)) {
        //     $search = strtolower($request->search);

        //     $query->whereRaw('LOWER(kunjungan_rutin.catatan) LIKE ?', ["%{$search}%"])
        //         ->orWhereRaw('LOWER(users.nama_lengkap) LIKE ?', ["%{$search}%"])
        //         ->orWhereRaw('LOWER(users.email) LIKE ?', ["%{$search}%"])
        //         ->orWhereRaw('LOWER(users.no_telp) LIKE ?', ["%{$search}%"])
        //         ->orWhereRaw('LOWER(customer.nama_customer) LIKE ?', ["%{$search}%"])
        //         ->orWhereRaw('LOWER(alamat_customer.alamat) LIKE ?', ["%{$search}%"])
        //         ->orWhereRaw("DATE_FORMAT(kunjungan_rutin.tgl_mulai, '%d/%m/%Y') LIKE ?", ["%{$search}%"])
        //         ->orWhereRaw("DATE_FORMAT(kunjungan_rutin.tgl_selesai, '%d/%m/%Y') LIKE ?", ["%{$search}%"]);
        // }

        if ($sort === 'oldest') {
            $query->orderByRaw('COALESCE(kunjungan_rutin.updated_at, kunjungan_rutin.created_at) ASC');
        } elseif ($sort === 'newest') {
            $query->orderByRaw('COALESCE(kunjungan_rutin.updated_at, kunjungan_rutin.created_at) DESC');
        } else {
            $query->orderByRaw('COALESCE(kunjungan_rutin.updated_at, kunjungan_rutin.created_at) DESC');
        }

        $komplain = $query->paginate(10); // 6 data per halaman

        // Format tanggal tanpa menghilangkan pagination
        $komplain->getCollection()->map(function ($item) {
            $item->created_at_formatted = Carbon::parse($item->created_at)->format('d M Y H:i');
            if ($item->updated_at) {
                $item->updated_at_formatted = Carbon::parse($item->updated_at)->format('d M Y H:i');
            }
            $item->tgl_mulai = Carbon::parse($item->tgl_mulai)->format('d/m/Y');
            $item->tgl_selesai = Carbon::parse($item->tgl_selesai)->format('d/m/Y');
            return $item;
        });

        return response()->json($komplain);
    }


    public function getKunjunganTeknisi(Request $request)
    {
        $sort = $request->query('sort', 'newest'); // Default sort: newest
        $idKunjunganRutin = $request->query('id_kunjungan_rutin', null);
        $query = KunjunganTeknisi::query()

            ->join('produk', 'produk.id_produk', '=', 'kunjungan_teknisi.id_produk')
            ->join('users', 'users.id', '=', 'kunjungan_teknisi.id_teknisi')

            ->where('kunjungan_teknisi.id_teknisi', auth()->id())

            ->select('kunjungan_teknisi.*', 'produk.judul');
        if ($idKunjunganRutin) {
            $query->where('kunjungan_teknisi.id_kunjungan_rutin', $idKunjunganRutin);
        }
        //dd($query->toSql());
        if ($request->has('search') && !empty($request->search)) {
            $search = strtolower($request->search);

            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(produk.judul) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(kunjungan_teknisi.catatan) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw("DATE_FORMAT(kunjungan_teknisi.tanggal, '%d/%m/%Y') LIKE ?", ["%{$search}%"]);
            });
        }

        if ($sort === 'oldest') {
            $query->orderByRaw('COALESCE(kunjungan_teknisi.updated_at, kunjungan_teknisi.created_at) ASC');
        } elseif ($sort === 'newest') {
            $query->orderByRaw('COALESCE(kunjungan_teknisi.updated_at, kunjungan_teknisi.created_at) DESC');
        } else {
            $query->orderByRaw('COALESCE(kunjungan_teknisi.updated_at, kunjungan_teknisi.created_at) DESC');
        }

        $kunjungan = $query->paginate(10); // 6 data per halaman

        // Format tanggal tanpa menghilangkan pagination
        $kunjungan->getCollection()->map(function ($item) {
            $item->created_at_formatted = Carbon::parse($item->created_at)->format('d M Y H:i');
            if ($item->updated_at) {
                $item->updated_at_formatted = Carbon::parse($item->updated_at)->format('d M Y H:i');
            }
            $item->tanggal = Carbon::parse($item->tanggal)->format('d/m/Y');

            return $item;
        });

        return response()->json($kunjungan);
    }
}
