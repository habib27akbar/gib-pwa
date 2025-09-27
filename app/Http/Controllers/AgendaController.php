<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absen;
use App\Models\Agenda;
use App\Models\Berita;
use App\Models\Produk;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use App\Models\JadwalTeknisi;
use App\Models\KomplainKunjungan;

class AgendaController extends Controller
{
    //
    public function index()
    {

        return view('welcome_page.agenda.index');
    }

    public function edit($id)
    {
        //$foto = Slider::all();
        //dd($sejarah);
        $berita = Agenda::findOrFail($id);

        return view('welcome_page.agenda.edit', compact('berita'));
    }

    public function getAgenda(Request $request)
    {
        $sort = $request->query('sort', 'newest'); // Default sort: newest

        $query = Agenda::query()->select('*');
        //dd($query->toSql());
        if ($request->has('search') && !empty($request->search)) {
            $search = strtolower($request->search); // Konversi ke huruf kecil untuk pencarian tidak case-sensitive
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(agenda.tema) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(agenda.isi_agenda) LIKE ?', ["%{$search}%"]);
            });
        }

        if ($sort === 'oldest') {
            $query->orderBy('agenda.tgl_posting', 'ASC');
        } elseif ($sort === 'newest') {
            $query->orderBy('agenda.tgl_posting', 'DESC');
        } else {
            $query->orderBy('agenda.tgl_posting', 'DESC');
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
