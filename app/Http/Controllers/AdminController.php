<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function postinganJson(){
        $data = DB::select("SELECT a.*, b.nama FROM posts a
                            LEFT JOIN users b ON b.nik = a.nik
                            ORDER BY a.id DESC;");

        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
    }

    public function postingan(){

        if (Auth::user()->nik !== 'daniel.it') {
            return view('403');
        }

        $post = DB::select("SELECT a.*, b.nama FROM posts a
                            LEFT JOIN users b ON b.nik = a.nik
                            ORDER BY a.id DESC;");

        return view('admin.postingan',compact('post'));
    }

    public function edit($id){

        if (Auth::user()->nik !== 'daniel.it') {
            return view('403');
        }

        $post = Post::findOrFail($id);

        return view('admin.editPostingan',compact('post'));
    }
    
    public function delete($id){
        if (Auth::user()->nik !== 'daniel.it') {
            return view('403');
        }
    }

}
