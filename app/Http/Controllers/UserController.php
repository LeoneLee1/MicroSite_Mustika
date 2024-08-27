<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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
            $data->save();
        } else {
            $data->nama = $request->nama;
            $data->nik = $request->nik;
            $data->unit = $request->unit;
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
}
