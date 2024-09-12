<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index(){

        $data = User::paginate(5);

        return view('users.index',compact('data'));
    }

    public function create(){
        return view('users.create');
    }

    public function insert(Request $request){
        $request->validate([
            'nama' => 'required',
            'nik' => 'required',
            'unit' => 'required',
            'password' => 'required',
        ]);

        $password = Hash::make($request->password);

        $data = new User();
        $data->nama = $request->nama;
        $data->nik = $request->nik;
        $data->unit = $request->unit;
        $data->password = $password;
        $data->gender = $request->gender;
        $data->foto = $request->foto;
        
        if ($data->save()) {
            Alert::success('Berhasil!','Membuat User baru.');
            return redirect('/user');
        } else {
            Alert::error('Gagal!','Membuat User baru.');
            return back();
        }
    }

    public function edit($id){
        $data = User::findOrFail($id);

        return view('users.edit',compact('data'));
    }

    public function update(Request $request, $id){

        $data = User::findOrFail($id);
        
        $newPassword = Hash::make($request->password);

        if ($request->password = '') {
            $data->nama = $request->nama;
            $data->nik = $request->nik;
            $data->unit = $request->unit;
            $data->gender = $request->gender;
            $data->foto = $request->foto;
            $data->save();
        } else {
            $data->nama = $request->nama;
            $data->nik = $request->nik;
            $data->unit = $request->unit;
            $data->gender = $request->gender;
            $data->foto = $request->foto;
            $data->password = $newPassword;
            $data->save();
        }

        Alert::success('Berhasil!','Merubah Data User.');
        return redirect('/user');
    }

    public function delete($id){
        $data = User::findOrFail($id);
        
        if ($data->delete()) {
            Alert::success('Berhasil!','Menghapus User.');
            return back();
        } else {
            Alert::error('Gagal!','Menghapus User.');
            return back();
        }
    }

    public function profile(){

        $user = Auth::user()->nik;

        $data = DB::select("SELECT * FROM users
                            WHERE nik = '$user'");

        return view('profile.index',compact('data'));
    }

    public function profileEdit(){
        $user = Auth::user()->nik;

        $unit = DB::select('SELECT * FROM units
                            ORDER BY kodeunit ASC');

        $data = DB::select("SELECT * FROM users
                            WHERE nik = '$user'");

        return view('profile.edit',compact('data','unit'));
    }

    public function profileInsert(Request $request){
        
        $data = User::find($request->input('id'));

        $id = $request->id;
        $nama = $request->nama;
        $nik = $request->nik;
        $unit = $request->unit;
        $gender = $request->gender;
        $foto = $request->foto;

        if ($unit == '' || $gender == '') {
            $sql = DB::statement("UPDATE users SET nama='$nama', nik='$nik', foto='$foto'
                                WHERE id = '$id'");    
        } else {
            $sql = DB::statement("UPDATE users SET nama='$nama', nik='$nik', unit='$unit',gender='$gender', foto='$foto'
                                WHERE id = '$id'");
        }

        

        Alert::success('Berhasil!','Mengubah Profile.');

        return redirect()->route('profile');
    }

}
