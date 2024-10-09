<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Save;
use App\Models\Unit;
use App\Models\User;
use App\Models\AkunRegis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{   

    public function json(){
        $data = User::orderBy('id','DESC')->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
    }

    public function jsonRegis(){
        $data = AkunRegis::all();

        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
    }

    public function index(){
        return view('users.index');
    }

    public function create(){

        $data = Unit::all();

        return view('users.create',compact('data'));
    }

    public function insert(Request $request){
        $request->validate([
            'nama' => 'required',
            'nik' => 'required',
            'unit' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);

        $password = Hash::make($request->password);

        $data = new User();
        $data->nama = $request->nama;
        $data->nik = $request->nik;
        $data->unit = $request->unit;
        $data->password = $password;
        $data->gender = $request->gender;
        $data->role = $request->role;
        
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

        $unit = Unit::all();

        return view('users.edit',compact('data','unit'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'nik' => 'required',
            'unit' => 'required',
            'gender' => 'nullable',
            'role' => 'required',
            'password' => 'nullable',
        ]);

        $data = User::findOrFail($id);

        if ($request->password === '' || $request->password === null) {
            $data->nama = $request->nama;
            $data->nik = $request->nik;
            $data->unit = $request->unit;
            $data->gender = $request->gender;
            $data->role = $request->role;
            $data->save();
        } else {
            $newPassword = Hash::make($request->password);
            $data->nama = $request->nama;
            $data->nik = $request->nik;
            $data->unit = $request->unit;
            $data->gender = $request->gender;
            $data->role = $request->role;
            $data->password = $newPassword;
            $data->save();
        }

        Alert::success('Berhasil!', 'Merubah Data User.');
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

        $post = DB::select("SELECT * FROM posts
                            WHERE nik = '$user'
                            ORDER BY id DESC;");

        return view('profile.index',compact('data','post'));
    }

    public function profileEdit(){
        $user = Auth::user()->nik;

        $unit = DB::select('SELECT * FROM units
                            ORDER BY kodeunit ASC');

        $data = DB::select("SELECT * FROM users
                            WHERE nik = '$user'");

        return view('profile.edit',compact('data','unit'));
    }

    public function profileInsert(Request $request)
    {   
        $request->validate([
            'foto' => 'nullable|image|mimes:png,jpg|max:2048',
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'unit' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:10'
        ]);

        $id = $request->id;
        $nama = $request->nama;
        $nik = $request->nik;
        $unit = $request->unit;
        $gender = $request->gender;

        $user = DB::table('users')->where('id', $id)->first();

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                $oldFilePath = public_path('img/foto/' . $user->foto);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $file = $request->file('foto');
            $foto_name = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/foto'), $foto_name);
        } else {
            $foto_name = $user->foto;
        }

        $dataToUpdate = [
            'nama' => $nama,
            'nik' => $nik,
            'unit' => $unit,
            'gender' => $gender,
            'foto' => $foto_name
        ];

        DB::table('users')
            ->where('id', $id)
            ->update($dataToUpdate);

        Alert::success('Berhasil!', 'Mengubah Profile.');

        return redirect()->route('profile');
    }

    public function dataRegisJson(){
        $data = AkunRegis::orderBy('id','DESC')->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
    }

    public function dataRegis(){
        return view('users.akunRegis');
    }
    public function dataRegisSee($id){

        $data = AkunRegis::findOrFail($id);

        return view('users.approve',compact('data'));
    }

    public function dataRegisApprove(Request $request, $id){
        $request->validate([
            'nama' => 'required',
            'nik' => 'required',
            'password' => 'required',
            'unit' => 'required',
            'role' => 'required',
        ]); 

        $password = Hash::make($request->password);

        $data = new User();
        $data->nama = $request->nama;
        $data->nik = $request->nik;
        $data->unit = $request->unit;
        $data->role = $request->role;
        $data->password = $password;
        $data->save();

        // kirim pesan
        $no_hp = $request->no_hp;
        $pesan = "Terima kasih telah mendaftar, Website MicroSite Mustika Username: {$request->nik}, Password: {$request->password}";
        $this->sendWa($no_hp, $pesan);

        Alert::success('Berhasil!','Menyimpan Akun.');

        $delete = AkunRegis::findOrFail($id);
        $delete->delete();

        return redirect()->route('user.regis');
        
    }

    public function dataRegisReject($id){
        $data = AkunRegis::findOrFail($id);

        if ($data) {
            $no_hp = $data->no_hp;
            // kirim pesan
            $no_hp = $data->no_hp;
            $pesan = "Mohon maaf, untuk pendaftaran akun MicroSite Mustika anda ditolak dikarenakan tidak sesuai, mohon dicoba lagi , Terima kasih";
            $this->sendWa($no_hp, $pesan);

            $data->delete();

            return back();
        } else {
            //
        }
        
    }

    private function sendWa($nowa, $pesan){
        $api_key = 'aDOYclFtJKAKPkRVRFWyAokb4LfyRM';
        $sender = '62882007021086';
        $url = 'https://wa.ptmustika.my.id/send-message';
        $param = array(
            "api_key" => $api_key,
            "sender" => $sender,
            "number" => $nowa, 
            "message" => $pesan
        );
    
        $json = json_encode($param);
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: '.strlen($json)
        ));
    
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $result = curl_exec($ch);
    
        curl_close($ch);
    }

    public function tersimpan(){
        $user = Auth::user()->nik;

        $data = DB::select("SELECT * FROM users
                            WHERE nik = '$user'");
        
        $save = DB::select("SELECT s.*, p.judul, p.media, p.deskripsi FROM saves s
                            LEFT JOIN posts p ON p.id = s.id_post
                            WHERE s.nik = '$user'");

        return view('profile.tersimpan',compact('data','save'));
    }

    public function tesimpanDelete($id){
        $data = Save::findOrFail($id);
        
        if ($data->delete()) {
            Alert::success('Berhasil!','Menghapus Postingan yang tersimpan.');
            return back();
        } else {
            Alert::error('Gagal!','Menghapus Postingan yang tersimpan.');
            return back();
        }
        
    }

}
