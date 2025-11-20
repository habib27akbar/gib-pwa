<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\AbsenKaryawan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class AbsenController extends Controller
{
    public function index()
    {
        return view('absen.index');
    }

    public function create()
    {
        return view('absen.create');
    }

    // public function store(Request $request)
    // {
    //     $nama_image = null;
    //     if ($request->file('image')) {
    //         $image = $request->file('image');
    //         $nama_image = 'absen-' . uniqid();
    //         $dir = 'img/absen';
    //         $image->move(public_path($dir), $nama_image);
    //     }

    //     if (auth()->id() == 2) {
    //         var_dump($nama_image);
    //         //exit;
    //     }



    //     $storeData = [
    //         'id_user' => auth()->id(),
    //         'tanggal' => date('Y-m-d'),
    //         'longitude' => $request->input('longitude'),
    //         'latitude' => $request->input('latitude'),
    //         'image' => $nama_image,

    //     ];
    //     AbsenKaryawan::create($storeData);
    //     return redirect('absen')->with('alert-success', 'Absen Sukses');
    // }


    public function store(Request $request)
    {
        $nama_image = null;

        if ($request->file('image')) {
            $image = $request->file('image');

            // nama unik + extension
            $nama_image = 'absen-' . uniqid() . '.' . $image->getClientOriginalExtension();

            // path simpan
            $dir = public_path('img/absen');
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }

            // proses dengan kompresi & orientasi
            Image::make($image->getRealPath())
                ->orientate() // fix rotasi dari EXIF
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save($dir . '/' . $nama_image, 35); // <-- angka 30 = kualitas
        }

        // if (auth()->id() == 2) {
        //     var_dump($nama_image);
        // }

        $storeData = [
            'id_user'   => auth()->id(),
            'tanggal'   => date('Y-m-d'),
            'longitude' => $request->input('longitude'),
            'latitude'  => $request->input('latitude'),
            'image'     => $nama_image,
        ];

        AbsenKaryawan::create($storeData);
        return redirect('absen')->with('alert-success', 'Absen Sukses');
    }


    // public function store(Request $request)
    // {
    //     // Validasi minimal
    //     $data = $request->validate([
    //         'image'     => ['nullable', 'image', 'max:10240'], // max 10MB
    //         'longitude' => ['nullable', 'string'],
    //         'latitude'  => ['nullable', 'string'],
    //     ]);

    //     $nama_image = null;
    //     $upload_time = 0;

    //     if ($request->hasFile('image') && $request->file('image')->isValid()) {
    //         $start = microtime(true);

    //         $ext = $request->file('image')->getClientOriginalExtension() ?: 'jpg';
    //         $nama_image = 'absen-' . uniqid() . '.' . $ext;

    //         // Simpan pakai Storage (lebih aman di cPanel)
    //         $request->file('image')->storeAs('public/absen', $nama_image);

    //         $upload_time = round(microtime(true) - $start, 3); // detik, dibulatkan 3 angka
    //     }


    //     // if (auth()->id() == 2) {
    //     //     logger()->info('UPLOAD DEBUG', [
    //     //         'file' => $nama_image,
    //     //         'upload_time_seconds' => $upload_time
    //     //     ]);

    //     //     return response()->json([
    //     //         'file' => $nama_image,
    //     //         'upload_time_seconds' => $upload_time
    //     //     ], 200);
    //     // }

    //     AbsenKaryawan::create([
    //         'id_user'   => auth()->id(),
    //         'tanggal'   => date('Y-m-d'),
    //         'longitude' => $request->input('longitude'),
    //         'latitude'  => $request->input('latitude'),
    //         'image'     => $nama_image,
    //     ]);

    //     return redirect('absen')->with('alert-success', 'Absen Sukses');
    // }

    public function getAbsenForTabulator()
    {
        try {
            $bulan = request('bulan') ?? date('Y-m');
            $tglAwal = Carbon::parse($bulan . '-01');
            $tglAkhir = $tglAwal->copy()->endOfMonth();
            $today = Carbon::today()->toDateString();

            // Generate all dates in month
            $tanggalList = [];
            $periode = $tglAwal->copy();
            while ($periode->lte($tglAkhir)) {
                $tanggalList[] = $periode->toDateString();
                $periode->addDay();
            }

            // Get grouped attendance data
            $absenList = AbsenKaryawan::whereMonth('tanggal', $tglAwal->month)
                ->whereYear('tanggal', $tglAwal->year)
                ->where('id_user', auth()->id())
                ->orderBy('tanggal')
                ->orderBy('created_at')
                ->get()
                ->groupBy(function ($item) {
                    return Carbon::parse($item->tanggal)->toDateString();
                });

            // Format for Tabulator
            $result = [];
            foreach ($tanggalList as $tanggal) {
                $absenHariIni = $absenList[$tanggal] ?? collect();

                //$masuk = $absenHariIni->first();
                $masuk = $absenHariIni->filter(function ($absen) {
                    return $absen->created_at->format('H:i') < '15:00';
                })->first(); // gunakan yang terakhir (paling akhir di atas jam 12:00)
                //$pulang = $absenHariIni->count() > 1 ? $absenHariIni->last() : null;
                $pulang = $absenHariIni->filter(function ($absen) {
                    return $absen->created_at->format('H:i') >= '15:00';
                })->last(); // gunakan yang terakhir (paling akhir di atas jam 12:00)

                $result[] = [
                    'tanggal' => Carbon::parse($tanggal)->translatedFormat('d M Y'),
                    'tanggal_raw' => $tanggal,
                    'masuk' => $masuk ? Carbon::parse($masuk->created_at)->format('H:i') : '-',
                    'pulang' => $pulang ? Carbon::parse($pulang->created_at)->format('H:i') : '-',
                    'is_today' => $tanggal === $today,
                    'status' => $this->getStatus($absenHariIni)
                ];
            }

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    protected function getStatus($absen)
    {
        if ($absen->isEmpty()) return 'Tidak Absen';
        if ($absen->count() === 1) return 'Masuk Saja';
        return 'Lengkap';
    }

    // Helper method untuk warna baris
    protected function getRowColor($absenHariIni)
    {
        if ($absenHariIni->isEmpty()) {
            return '#ffe6e6'; // Merah muda untuk tidak absen
        }

        if ($absenHariIni->count() === 1) {
            return '#fff3e6'; // Kuning muda untuk hanya masuk
        }

        return '#f0fff0'; // Hijau muda untuk lengkap
    }
}
