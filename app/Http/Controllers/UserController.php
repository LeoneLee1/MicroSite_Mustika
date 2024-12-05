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

        $notifPost = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul FROM notif_post a
                                    LEFT JOIN users b ON b.nik = a.nik
                                    LEFT JOIN posts c ON c.id = a.id_post
                                    ORDER BY a.id DESC
                                    LIMIT 2;");
        
        $notifPostLike = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul, c.nik AS nik_post FROM notif_post_like a
                                    LEFT JOIN users b ON b.nik = a.nik
                                    LEFT JOIN posts c ON c.id = a.id_post
                                    ORDER BY a.id DESC
                                    LIMIT 1;");

        $notifPostComment = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul, c.nik AS nik_post 
                                    FROM notif_post_comment a
                                    LEFT JOIN users b ON b.nik = a.nik
                                    LEFT JOIN posts c ON c.id = a.id_post
                                    ORDER BY a.id DESC
                                    LIMIT 1;");

        return view('users.index',compact('notifPost','notifPostLike','notifPostComment'));
    }

    public function create(){

        $data = Unit::all();

        $ap = DB::select("SELECT * FROM tbl_pt ORDER BY koderegion ASC;");

        $notifPost = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul FROM notif_post a
                                    LEFT JOIN users b ON b.nik = a.nik
                                    LEFT JOIN posts c ON c.id = a.id_post
                                    ORDER BY a.id DESC
                                    LIMIT 2;");

        $notifPostLike = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul, c.nik AS nik_post FROM notif_post_like a
                                    LEFT JOIN users b ON b.nik = a.nik
                                    LEFT JOIN posts c ON c.id = a.id_post
                                    ORDER BY a.id DESC
                                    LIMIT 1;");

        $notifPostComment = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul, c.nik AS nik_post 
                                    FROM notif_post_comment a
                                    LEFT JOIN users b ON b.nik = a.nik
                                    LEFT JOIN posts c ON c.id = a.id_post
                                    ORDER BY a.id DESC
                                    LIMIT 1;");

        return view('users.create',compact('data','ap','notifPost','notifPostLike','notifPostComment'));
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
        $data->no_hp = $this->no_wa($request->no_hp);
        $data->role = $request->role;

        $existingData = User::where('nik',$request->nik)->exists();

        if ($existingData) {
            Alert::error('Gagal!','Maaf NIK sudah terdaftar.');
            return redirect()->back();
        } elseif($data->save()) {
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

        $ap = DB::select("SELECT * FROM tbl_pt ORDER BY koderegion ASC;");

        $notifPost = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul FROM notif_post a
                                    LEFT JOIN users b ON b.nik = a.nik
                                    LEFT JOIN posts c ON c.id = a.id_post
                                    ORDER BY a.id DESC
                                    LIMIT 2;");

        $notifPostLike = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul, c.nik AS nik_post FROM notif_post_like a
                                LEFT JOIN users b ON b.nik = a.nik
                                LEFT JOIN posts c ON c.id = a.id_post
                                ORDER BY a.id DESC
                                LIMIT 1;");

        $notifPostComment = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul, c.nik AS nik_post 
                                FROM notif_post_comment a
                                LEFT JOIN users b ON b.nik = a.nik
                                LEFT JOIN posts c ON c.id = a.id_post
                                ORDER BY a.id DESC
                                LIMIT 1;");

        return view('users.edit',compact('data','unit','ap','notifPost','notifPostLike','notifPostComment'));
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
            $data->no_hp = $this->no_wa($request->no_hp);
            $data->gender = $request->gender;
            $data->role = $request->role;
            $data->save();
        } else {
            $newPassword = Hash::make($request->password);
            $data->nama = $request->nama;
            $data->nik = $request->nik;
            $data->unit = $request->unit;
            $data->no_hp = $this->no_wa($request->no_hp);
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
                            
        $save = DB::select("SELECT s.*, p.judul, p.media, p.media_file, p.deskripsi FROM saves s
                            LEFT JOIN posts p ON p.id = s.id_post
                            WHERE s.nik = '$user'");

        $notifPost = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul FROM notif_post a
                                LEFT JOIN users b ON b.nik = a.nik
                                LEFT JOIN posts c ON c.id = a.id_post
                                ORDER BY a.id DESC
                                LIMIT 2;");

        $notifPostLike = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul, c.nik AS nik_post FROM notif_post_like a
                            LEFT JOIN users b ON b.nik = a.nik
                            LEFT JOIN posts c ON c.id = a.id_post
                            ORDER BY a.id DESC
                            LIMIT 1;");

        $notifPostComment = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul, c.nik AS nik_post 
                            FROM notif_post_comment a
                            LEFT JOIN users b ON b.nik = a.nik
                            LEFT JOIN posts c ON c.id = a.id_post
                            ORDER BY a.id DESC
                            LIMIT 1;");

        return view('profile.index',compact('data','post','save','notifPost','notifPostLike','notifPostComment'));
    }

    public function profileEdit(){
        $user = Auth::user()->nik;

        $unit = DB::select('SELECT * FROM units
                            ORDER BY kodeunit ASC');

        $ap = DB::select("SELECT * FROM tbl_pt ORDER BY koderegion ASC;");

        $data = DB::select("SELECT * FROM users
                            WHERE nik = '$user'");

        $notifPost = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul FROM notif_post a
                                LEFT JOIN users b ON b.nik = a.nik
                                LEFT JOIN posts c ON c.id = a.id_post
                                ORDER BY a.id DESC
                                LIMIT 2;");
        $notifPostLike = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul, c.nik AS nik_post FROM notif_post_like a
                                LEFT JOIN users b ON b.nik = a.nik
                                LEFT JOIN posts c ON c.id = a.id_post
                                ORDER BY a.id DESC
                                LIMIT 1;");

        $notifPostComment = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul, c.nik AS nik_post 
                                FROM notif_post_comment a
                                LEFT JOIN users b ON b.nik = a.nik
                                LEFT JOIN posts c ON c.id = a.id_post
                                ORDER BY a.id DESC
                                LIMIT 1;");

        return view('profile.edit',compact('data','unit','ap','notifPost','notifPostLike','notifPostComment'));
    }

    public function profileInsert(Request $request)
    {   
        $request->validate([
            'foto' => 'nullable|image|mimes:png,jpg|max:2048',
            'nama' => 'required',
            'unit' => 'nullable',
            'gender' => 'nullable|string|max:10',
            'password' => 'nullable',
        ]);

        $id = $request->id;
        $nama = $request->nama;
        $unit = $request->unit;
        $no_hp = $this->no_wa($request->no_hp);
        $gender = $request->gender;
        $password = $request->password;

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
            'unit' => $unit,
            'no_hp' => $no_hp,
            'gender' => $gender,
            'foto' => $foto_name,
        ];

        if (!empty($password)) {
            $dataToUpdate['password'] = Hash::make($password);
        }

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

        $notifPost = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul FROM notif_post a
                                    LEFT JOIN users b ON b.nik = a.nik
                                    LEFT JOIN posts c ON c.id = a.id_post
                                    ORDER BY a.id DESC
                                    LIMIT 2;");

        $notifPostLike = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul, c.nik AS nik_post FROM notif_post_like a
                                    LEFT JOIN users b ON b.nik = a.nik
                                    LEFT JOIN posts c ON c.id = a.id_post
                                    ORDER BY a.id DESC
                                    LIMIT 1;");

        $notifPostComment = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul, c.nik AS nik_post 
                                    FROM notif_post_comment a
                                    LEFT JOIN users b ON b.nik = a.nik
                                    LEFT JOIN posts c ON c.id = a.id_post
                                    ORDER BY a.id DESC
                                    LIMIT 1;");

        return view('users.akunRegis',compact('notifPost','notifPostLike','notifPostComment'));
    }
    public function dataRegisSee($id){

        $data = AkunRegis::findOrFail($id);

        $notifPost = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul FROM notif_post a
                                    LEFT JOIN users b ON b.nik = a.nik
                                    LEFT JOIN posts c ON c.id = a.id_post
                                    ORDER BY a.id DESC
                                    LIMIT 2;");

        $notifPostLike = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul, c.nik AS nik_post FROM notif_post_like a
                                    LEFT JOIN users b ON b.nik = a.nik
                                    LEFT JOIN posts c ON c.id = a.id_post
                                    ORDER BY a.id DESC
                                    LIMIT 1;");

        $notifPostComment = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul, c.nik AS nik_post 
                                    FROM notif_post_comment a
                                    LEFT JOIN users b ON b.nik = a.nik
                                    LEFT JOIN posts c ON c.id = a.id_post
                                    ORDER BY a.id DESC
                                    LIMIT 1;");

        return view('users.approve',compact('data','notifPost','notifPostLike','notifPostComment'));
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
        $data->gender = $request->gender;
        $data->no_hp = $request->no_hp;
        $data->password = $password;
        $data->save();

        // kirim pesan
        $no_hp = $request->no_hp;
        $pesan = "*Terima kasih telah mendaftar di Website MicroSite Pendarrasa!*

Berikut informasi akun Anda:
*Username:* {$request->nik}  
*Password:* {$request->password}  

Silakan gunakan informasi ini untuk login.
Jika Anda membutuhkan bantuan, jangan ragu untuk menghubungi tim kami.

Terima kasih,
*Pendarrasa MicroSite*";

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
            $pesan = "Mohon maaf, untuk pendaftaran akun MicroSite Pendar rasa anda ditolak dikarenakan tidak sesuai, mohon dicoba lagi , Terima kasih";
            $this->sendWa($no_hp, $pesan);

            $data->delete();

            return back();
        } else {
            //
        }
        
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
