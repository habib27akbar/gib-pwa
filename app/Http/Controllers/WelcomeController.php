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
use App\Models\HalamanStatis;
use App\Models\Visi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index()
    {
        return view('welcome_page.index');
    }

    public function home_page()
    {
        return view('welcome_page.home');
    }

    public function visi_misi()
    {
        $visi_misi = HalamanStatis::where('id_halaman', 1)->first();
        $visi = Visi::all();
        $latar_belakang = HalamanStatis::where('id_halaman', 2)->first();
        $sejarah = HalamanStatis::where('id_halaman', 3)->first();
        $objektif = HalamanStatis::where('id_halaman', 4)->first();
        return view('welcome_page.tentang_gib.index', compact('visi_misi', 'visi', 'latar_belakang', 'sejarah', 'objektif'));
    }

    public function catalog()
    {
        return view('welcome_page.catalog.index');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('welcome_page.catalog.edit', compact('produk'));
    }

    public function getCatalogWelcome(Request $request)
    {
        $sort = $request->query('sort', 'newest'); // Default sort: newest

        $query = Produk::query()->select('*');
        //dd($query->toSql());
        if ($request->has('search') && !empty($request->search)) {
            $search = strtolower($request->search); // Konversi ke huruf kecil untuk pencarian tidak case-sensitive
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(produk.judul) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(produk.isi_produk) LIKE ?', ["%{$search}%"]);
            });
        }

        if ($sort === 'oldest') {
            $query->orderBy('produk.waktu_input', 'ASC');
        } elseif ($sort === 'newest') {
            $query->orderBy('produk.waktu_input', 'DESC');
        } else {
            $query->orderBy('produk.waktu_input', 'DESC');
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
