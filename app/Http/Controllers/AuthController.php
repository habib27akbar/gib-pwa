<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Mews\Captcha\Facades\Captcha;
use App\Models\User;
use App\Models\UnitKerja;
use App\Models\UserUnitKerja;

class AuthController extends Controller
{
    public function index()
    {
        $user = User::with('unitKerja.unitKerjaDetail')->get();

        //dd($user);
        return view('master.user.index', compact('user'));
    }

    public function create()
    {
        $unit_kerja = UnitKerja::all();
        return view('master.user.create', compact('unit_kerja'));
    }

    public function edit($id)
    {
        $unit_kerja = UnitKerja::all();
        $user = User::findOrFail($id);
        $user_unit_kerja = UserUnitKerja::where('id_user', $user->id)->get(); // Ambil semua data sebagai koleksi
        //dd($user);
        //dd($user_unit_kerja);
        return view('master.user.edit', compact('unit_kerja', 'user', 'user_unit_kerja'));
    }

    public function form_login()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // $credentials = $request->only('username', 'password');

        // if (Auth::attempt($credentials)) {
        //     $request->session()->regenerate();
        //     return redirect()->intended('/home');
        // }

        // return back()->with('alert-danger', 'Login Failed!');

        // Validasi input termasuk CAPTCHA
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
            'captcha' => 'required|captcha',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/home');
        }

        $user = User::where('username', $request->input('username'))->first();

        if (!$user) {
            return back()->with('alert-danger', 'Username tidak ditemukan');
        }

        if (Hash::check($request->input('password'), $user->password)) {
            return back()->with('alert-danger', 'Password salah');
        }

        return back()->with('alert-danger', 'Login Failed!');
    }



    public function store(Request $request)
    {
        // Validasi input agar tidak ada data kosong atau tidak valid
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'no_hp' => 'required|string|max:15',
            'password' => 'required|string|min:6|confirmed',
            'user_unit_kerja' => 'nullable|array',
            'user_unit_kerja.*' => 'exists:unit_kerja,id', // Pastikan ID unit kerja valid
        ]);
        //dd($validated);

        // Gunakan transaksi agar jika ada error, data tidak terpotong
        DB::beginTransaction();
        try {
            // 🔍 Cek apakah kode masuk ke sini
            $nama_image = null;
            if ($request->file('foto')) {
                $image = $request->file('foto');
                $nama_image = 'foto-' . uniqid() . '-' . $image->getClientOriginalName();
                $dir = 'img/foto';
                $image->move(public_path($dir), $nama_image);
            }
            // Buat user baru
            $user = User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'no_hp' => $validated['no_hp'],
                'foto' => $nama_image,
                'password' => Hash::make($validated['password'])
            ]);
            //exit;



            // Jika ada unit kerja, masukkan ke tabel UserUnitKerja
            if (!empty($validated['user_unit_kerja'])) {
                foreach ($validated['user_unit_kerja'] as $post_unit_kerja) {
                    UserUnitKerja::create([
                        'id_unit_kerja' => $post_unit_kerja,
                        'id_user' => $user->id
                    ]);
                }
            }

            DB::commit(); // Simpan perubahan ke database

            return redirect('auth')->with('alert-success', 'Success Tambah Data');
        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan jika ada kesalahan
            return back()->with('alert-danger', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'password' => 'nullable|string|min:6|confirmed', // Bisa kosong
            'user_unit_kerja' => 'nullable|array',
            'user_unit_kerja.*' => 'exists:unit_kerja,id', // Pastikan ID unit kerja valid
        ]);

        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            $user->name = $validated['name'];
            $user->username = $validated['username'];
            $user->no_hp = $validated['no_hp'];

            // Proses foto
            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if (!empty($user->foto) && file_exists(public_path('img/foto/' . $user->foto))) {
                    unlink(public_path('img/foto/' . $user->foto));
                }

                // Simpan foto baru
                $image = $request->file('foto');
                $nama_image = 'foto-' . uniqid() . '-' . $image->getClientOriginalName();
                $image->move(public_path('img/foto'), $nama_image);
                $user->foto = $nama_image;
            }

            // Update password hanya jika diisi
            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }

            $user->save();

            // Hapus semua unit kerja lama
            UserUnitKerja::where('id_user', $user->id)->delete();

            // Tambahkan unit kerja baru jika ada
            if (!empty($validated['user_unit_kerja'])) {
                $unit_kerja_data = array_map(function ($unit) use ($user) {
                    return [
                        'id_unit_kerja' => $unit,
                        'id_user' => $user->id,
                    ];
                }, $validated['user_unit_kerja']);

                UserUnitKerja::insert($unit_kerja_data);
            }

            DB::commit();
            return redirect()->route('auth.index')->with('alert-success', 'User updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('alert-danger', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }



    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        // Hapus semua unit kerja lama
        UserUnitKerja::where('id_user', $id)->delete();
        return redirect('unit_kerja')->with('alert-success', 'Success deleted data');
    }
}
