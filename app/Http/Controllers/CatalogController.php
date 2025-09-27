<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absen;
use App\Models\Produk;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use App\Models\JadwalTeknisi;
use App\Models\KomplainKunjungan;

class CatalogController extends Controller
{
    //
    public function index()
    {

        return view('catalog.index');
    }

    public function edit($id)
    {
        //$foto = Slider::all();
        //dd($sejarah);
        $produk = Produk::findOrFail($id);

        return view('catalog.edit', compact('produk'));
    }

    public function getCatalog(Request $request)
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
