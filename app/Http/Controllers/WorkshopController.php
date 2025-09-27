<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Models\Workshop;

use Illuminate\Http\Request;


class WorkshopController extends Controller
{
    //
    public function index()
    {

        return view('welcome_page.workshop.index');
    }

    public function edit($id)
    {
        //$foto = Slider::all();
        //dd($sejarah);
        $workshop = Workshop::findOrFail($id);
        return view('welcome_page.workshop.edit', compact('workshop'));
    }

    public function getWorkshop(Request $request)
    {
        $sort = $request->query('sort', 'newest'); // Default sort: newest

        $query = Workshop::query()->select('*');
        //dd($query->toSql());
        if ($request->has('search') && !empty($request->search)) {
            $search = strtolower($request->search); // Konversi ke huruf kecil untuk pencarian tidak case-sensitive
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(workshop.judul) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(workshop.isi_workshop) LIKE ?', ["%{$search}%"]);
            });
        }

        if ($sort === 'oldest') {
            $query->orderBy('workshop.tgl_posting', 'ASC');
        } elseif ($sort === 'newest') {
            $query->orderBy('workshop.tgl_posting', 'DESC');
        } else {
            $query->orderBy('workshop.tgl_posting', 'DESC');
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
