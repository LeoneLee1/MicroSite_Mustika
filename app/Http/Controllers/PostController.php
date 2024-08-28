<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PostController extends Controller
{
    public function index(){
        return view('post.index');
    }

    public function insert(Request $request){
        $request->validate([
            'nik' => 'required',
            'judul' => 'required',
            'media' => 'required',
            'deskripsi' => 'required',
        ]);

        $post = new Post();
        $post->nik = $request->nik;
        $post->judul = $request->judul;
        $post->media = $request->media;
        $post->deskripsi = $request->deskripsi;
        $post->save();

        if ($request->has('polling')) {
            Alert::success('Berhasil!','Membuat Post.');
            return redirect()->route('polling.create');
        } else {
            Alert::success('Berhasil!','Membuat Post.');
            return back();
        }

        // if ($post->save()) {
        //     Alert::success('Berhasil!','Membuat Post.');
        //     return back();
        // } else {
        //     Alert::error('Gagal!','Membuat Post.');
        //     return back();
        // }
        
    }
}
