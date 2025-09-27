<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absen;
use App\Models\Berita;
use App\Models\Produk;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use App\Models\JadwalTeknisi;
use App\Models\KomplainKunjungan;

class BeritaController extends Controller
{
    //
    public function index()
    {

        return view('welcome_page.berita.index');
    }

    public function edit($id)
    {
        //$foto = Slider::all();
        //dd($sejarah);
        $berita = Berita::findOrFail($id);

        return view('welcome_page.berita.edit', compact('berita'));
    }

    public function getBerita(Request $request)
    {
        $sort = $request->query('sort', 'newest'); // Default sort: newest

        $query = Berita::query()->select('*');
        //dd($query->toSql());
        if ($request->has('search') && !empty($request->search)) {
            $search = strtolower($request->search); // Konversi ke huruf kecil untuk pencarian tidak case-sensitive
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(berita.judul) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(berita.isi_berita) LIKE ?', ["%{$search}%"]);
            });
        }

        if ($sort === 'oldest') {
            $query->orderBy('berita.tanggal', 'ASC');
        } elseif ($sort === 'newest') {
            $query->orderBy('berita.tanggal', 'DESC');
        } else {
            $query->orderBy('berita.tanggal', 'DESC');
        }

        $komplain = $query->paginate(10); // 6 data per halaman

        // Format tanggal tanpa menghilangkan pagination
        // $komplain->getCollection()->map(function ($item) {
        //     $item->created_at_formatted = Carbon::parse($item->created_at)->format('d M Y H:i');
        //     if ($item->updated_at) {
        //         $item->updated_at_formatted = Carbon::parse($item->updated_at)->format('d M Y H:i');
        //     }

        //     return $item;
        // });

        return response()->json($komplain);
    }
}
