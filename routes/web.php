<?php

<<<<<<< HEAD
use App\Models\Unit;
use App\Models\User;
use App\Models\Produk;
use App\Models\ItemCustomer;
use App\Models\UlasanProduk;
use Illuminate\Http\Request;
use App\Models\AlamatCustomer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CatalogWelcomeController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\KomplainController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\QrProdukController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\ScanProdukController;
use App\Http\Controllers\KunjunganKomplainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\WorkshopController;
use Illuminate\Support\Facades\Auth;
=======
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KomplainController;
use App\Http\Controllers\KunjunganController;

>>>>>>> e92709dadf761bb5743b7595b7e4d812ec08228e
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('auth.login');
// })->name('login');
Route::get('/', function () {
<<<<<<< HEAD
    if (Auth::check()) {
        return redirect()->route('home');
    }
    // return view('auth.login');
    return redirect()->route('welcome.home_page');
});

=======
    return view('auth.login');
})->name('login');
Route::get('/home', [HomeController::class, 'index'])->name('home');
>>>>>>> e92709dadf761bb5743b7595b7e4d812ec08228e
Route::post('/login', [AuthController::class, 'login'])->name('authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/login', [AuthController::class, 'form_login'])->name('login');

Route::get('/captcha-refresh', function () {
    return response()->json(['captcha' => captcha_src()]);
})->name('captcha.refresh');

// Route::resource('qr_produk', QrProdukController::class);
Route::get('qr_produk/{param}/edit', [QrProdukController::class, 'editCustom'])->name('qr_produk.edit_custom');
Route::get('welcome_page', [WelcomeController::class, 'index'])->name('welcome_page.index');
Route::get('/home-page', [WelcomeController::class, 'home_page'])->name('welcome.home_page');
Route::get('/welcome_page/visi-misi', [WelcomeController::class, 'visi_misi'])->name('welcome.visi_misi');
Route::get('/welcome_page/catalog', [WelcomeController::class, 'catalog'])->name('welcome.catalog');
Route::resource('privacy', PrivacyController::class);
Route::resource('scan_produk', ScanProdukController::class);

Route::resource('catalog_welcome', CatalogWelcomeController::class);
Route::resource('berita', BeritaController::class);
Route::resource('agenda', AgendaController::class);
Route::resource('video', VideoController::class);
Route::resource('workshop', WorkshopController::class);
Route::get('welcome_page/{id}/edit', [WelcomeController::class, 'edit'])->name('welcome_page.edit');
Route::get('/api/catalog_welcome', [CatalogWelcomeController::class, 'getCatalogWelcome']);
Route::get('/api/berita', [BeritaController::class, 'getBerita']);
Route::get('/api/agenda', [AgendaController::class, 'getAgenda']);
Route::get('/api/video', [VideoController::class, 'getVideo']);
Route::get('/api/workshop', [WorkshopController::class, 'getWorkshop']);
Route::group(['middleware' => 'auth'], function () {
    Route::get('/check-username', function (Request $request) {
        $query = User::where('username', $request->query('username'));

        // Abaikan pengecekan jika sedang edit dan ID dikirim
        if ($request->has('id')) {
            $query->where('id', '!=', $request->query('id'));
        }

        $exists = $query->exists();
        return response()->json(['exists' => $exists]);
    });

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('auth', AuthController::class);
    Route::resource('komplain', KomplainController::class);
    Route::get('/api/komplain', [KomplainController::class, 'getKomplain']);
    Route::resource('kunjungan', KunjunganController::class);
    Route::get('/api/kunjungan', [KunjunganController::class, 'getKunjungan']);
<<<<<<< HEAD
    Route::get('/api/kunjungan_teknisi', [KunjunganController::class, 'getKunjunganTeknisi']);
    Route::post('/kunjungan/{kunjungan}/absen', [KunjunganController::class, 'absen'])
        ->name('kunjungan.absen');

    Route::get('/history/{id_produk}/{id_lokasi}', [HistoryController::class, 'show'])->name('history.show');

    Route::resource('kunjungan_komplain', KunjunganKomplainController::class);
    Route::resource('penilaian', PenilaianController::class);
    Route::get('/api/kunjungan_komplain', [KunjunganKomplainController::class, 'getKunjungan']);
    Route::post('/kunjungan_komplain/{kunjungan}/absen', [KunjunganKomplainController::class, 'absen'])
        ->name('kunjungan.absen');
    Route::resource('produk', ProdukController::class);
    Route::resource('catalog', CatalogController::class);
    Route::get('/api/catalog', [CatalogController::class, 'getCatalog']);

    Route::get('kunjungan_komplain/create_laporan', [KunjunganKomplainController::class, 'create_laporan']);


    Route::resource('absen', AbsenController::class);
    Route::get('/absensi', [AbsenController::class, 'getAbsenForTabulator']);
    Route::resource('kontak', KontakController::class);
    Route::resource('profile', ProfileController::class);
    Route::get('/get-customer-alamat/', function () {
        //DB::enableQueryLog();
        $alamat = AlamatCustomer::select('id', 'id_customer', 'alamat')
            ->where('id_customer', auth()->user()->id_customer)
            ->get();
        //dd($alamat->toSql());
        //dd(DB::getQueryLog());
        return response()->json($alamat);
    })->name('get.lokasi');

    Route::post('/produk/ulasan', [ProdukController::class, 'ulasan'])
        ->name('produk.ulasan');

    Route::get('/get-produk-customer/{id}', function ($id) {
        $alamat = ItemCustomer::select('item_customer.id', 'item_customer.id_produk', 'produk.judul', 'produk.gambar', 'produk.isi_produk')
            ->join('produk', 'produk.id_produk', '=', 'item_customer.id_produk')
            ->where('item_customer.id_lokasi', $id)->get();
        return response()->json($alamat);
    });

    Route::get('/get-produk/{id}', function ($id) {
        $produk = Produk::select('id_produk', 'judul')
            ->where('id_produk', $id)->get();
        return response()->json($produk);
    });

    Route::get('/get-ulasan/{id_customer}/{id_produk}/{id_lokasi}', function ($id_customer, $id_produk, $id_lokasi) {
        $ulasan_produk = UlasanProduk::select('bintang', 'ulasan')
            ->where('id_produk', $id_produk)
            ->where('id_customer', $id_customer)
            ->where('id_lokasi', $id_lokasi)
            ->get();

        return response()->json($ulasan_produk);
    });

    Route::get('/get-produk-with-unit-customer/{id}', function ($id) {
        $data = DB::table('item_customer')
            ->join('produk', 'produk.id_produk', '=', 'item_customer.id_produk')
            ->leftJoin('unit', 'unit.id_item_customer', '=', 'item_customer.id')
            ->leftJoin('ulasan_produk as up2', function ($join) {
                $join->on('up2.id_produk', '=', 'item_customer.id_produk')
                    ->on('up2.id_customer', '=', 'item_customer.id_customer')
                    ->on('up2.id_lokasi', '=', 'item_customer.id_lokasi');
            })
            ->where('item_customer.id_lokasi', $id)
            ->select(
                'item_customer.id',
                'item_customer.id_customer as id_customer_item',
                'item_customer.id_produk',
                'item_customer.id_lokasi',
                'produk.judul',
                'produk.gambar',
                'produk.isi_produk',
                'unit.serial_number',
                'unit.tgl_pembelian',
                'unit.id as unit_id',
                'up2.id as id_ulasan',
                'up2.bintang',
                'up2.ulasan',
                'up2.status',
            )
            ->get();

        // Gabungkan unit berdasarkan item_customer
        $grouped = [];

        foreach ($data as $row) {
            $id = $row->id;

            if (!isset($grouped[$id])) {
                $grouped[$id] = [
                    'id' => $row->id,
                    'id_produk' => $row->id_produk,
                    'id_lokasi' => $row->id_lokasi,
                    'judul' => $row->judul,
                    'gambar' => $row->gambar,
                    'isi_produk' => $row->isi_produk,
                    'id_customer_item' => $row->id_customer_item,
                    'id_ulasan' => $row->id_ulasan,
                    'bintang' => $row->bintang,
                    'ulasan' => $row->ulasan,
                    'status' => $row->status,
                    'units' => [],
                ];
            }

            // Tambahkan unit jika ada
            if ($row->unit_id) {
                $grouped[$id]['units'][] = [
                    'serial_number' => $row->serial_number,
                    'tgl_pembelian' => $row->tgl_pembelian,
                ];
            }
        }

        return response()->json(array_values($grouped));
    });

    Route::get('/get-unit-customer/{id}', function ($id) {
        $unit = Unit::select('id', 'id_item_customer', 'serial_number', 'tgl_pembelian', 'keterangan')
            ->where('id_item_customer', $id)->get();
        return response()->json($unit);
    });
=======
    Route::post('/kunjungan/{kunjungan}/absen', [KunjunganController::class, 'absen'])
        ->name('kunjungan.absen');
>>>>>>> e92709dadf761bb5743b7595b7e4d812ec08228e
});
