<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\User;
use App\Models\AkunRegis;
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
            return redirect('/beranda');
        } else {
            Alert::error('Gagal!','Nik atau Password anda salah!');
            return redirect('/login');
        }
    }

    public function register(){

        $unit = DB::select('SELECT * FROM units
                            ORDER BY kodeunit ASC;');

        return view('register',compact('unit'));
    }

    public function insert(Request $request){
        $request->validate([
            'nama' => 'required',
            'nik' => 'required',
            'no_hp' => 'required',
            'unit' => 'required',
        ]);

        $cekNikUsers = User::where('nik',$request->nik)->first();
        $cekNikRegister = AkunRegis::where('nik',$request->nik)->first();

        if ($cekNikUsers) {
            Alert::error('Gagal!','Mohon Maaf NIK yang anda masukkan sudah terdaftar.');
            return redirect()->back();
        } elseif($cekNikRegister){
            Alert::error('Gagal!','Mohon Maaf NIK yang anda masukkan sudah terdaftar.');
            return redirect()->back();
        } else {
            $register = new AkunRegis();
            $register->nama = $request->nama;
            $register->nik = $request->nik;
            $register->no_hp = $this->no_wa($request->no_hp);
            $register->unit = $request->unit;
    
            if ($register->save()) {
                return view('informasi-sukses');
            } else {
                Alert::error('Gagal!','Membuat Akun, Silahkann Coba Lagi.');
                return redirect()->back();
            }
        }
    }

    public function resetAkun(){
        //
    }
    
    private function no_wa($nohp){
        $nohp = trim($nohp); 
        if(!preg_match("/[^+0-9]/", $nohp)){
            if(substr($nohp, 0, 2) == "62"){
                return $nohp; 
            }
            else if(substr($nohp, 0, 1) == "0"){
                return "62" . substr($nohp, 1); 
            }
        }
        return $nohp; 
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
