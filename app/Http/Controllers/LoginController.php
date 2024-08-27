<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    public function login(){
        return view('login');
    }

    public function proses(Request $request){
        if (Auth::attempt($request->only('nik','password'))) {
            return redirect('/');
        } else {
            Alert::error('Gagal!','Nik atau Password anda salah!');
            return redirect('/login');
        }
    }

    public function register(){

        $unit = DB::select('SELECT * FROM units
                            ORDER BY kodeunit ASC');

        return view('register',compact('unit'));
    }

    public function insert(Request $request){
        $request->validate([
            'nama' => 'required',
            'nik' => 'required',
            'unit' => 'required',
            'password' => 'required',
        ]);

        $password = Hash::make($request->password);

        $register = new User();
        $register->nama = $request->nama;
        $register->nik = $request->nik;
        $register->unit = $request->unit;
        $register->password = $password;

        if ($register->save()) {
            Alert::success('Berhasil!','Membuat Akun.');
            return redirect()->route('login');
        } else {
            Alert::error('Gagal!','Membuat Akun, Silahkann Coba Lagi.');
            return back();
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
