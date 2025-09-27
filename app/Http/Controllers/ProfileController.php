<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    public function index()
    {
        $user = User::where('id', Auth::user()->id)->first();
        $customer = null;
        if (Auth::user()->id_customer) {
            $customer = Customer::where('id', Auth::user()->id_customer)->first();
        }
        return view('profile.index', compact('user', 'customer'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validasi input
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_telp' => 'nullable|string|max:20',
            'email' => 'required|email',
            'username' => 'required|string|max:255',
            'katasandi_lama' => 'nullable|string',
            'katasandi_baru' => 'nullable|string|min:6|same:konfirmasi_katasandi_baru',
        ]);

        // Update info profil
        $user->nama_lengkap = $request->nama_lengkap;
        $user->no_telp = $request->no_telp;
        $user->email = $request->email;
        $user->username = $request->username;

        // Proses ubah password jika ada input
        if ($request->filled('katasandi_lama') && $request->filled('katasandi_baru')) {
            if (!Hash::check($request->katasandi_lama, $user->password)) {
                return back()->with('error', 'Katasandi lama tidak sesuai.');
            }

            $user->password = Hash::make($request->katasandi_baru);
            $user->pwd = $request->katasandi_baru;
        }

        $user->save();
        if (Auth::user()->id_customer) {

            $updateData = [

                'nama_customer' => $request->input('nama_lengkap'),
                'email' => $request->input('email'),
                'telp' => $request->input('no_telp')
            ];

            Customer::where('id', Auth::user()->id_customer)->update($updateData);
        }

        return redirect('profile')->with('alert-success', 'Success Update Data');
    }
}
