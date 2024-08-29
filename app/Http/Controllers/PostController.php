<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Stichoza\GoogleTranslate\GoogleTranslate;

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
        

        if ($request->has('polling')) {
            $post->save();
            Alert::success('Berhasil!','Membuat Post.');
            return redirect()->route('polling.create');
        } elseif($post->save()) {
            Alert::success('Berhasil!','Membuat Post.');
            return back();
        } else {
            Alert::error('Gagal!','Membuat Post, Mohon Coba Lagi.');
            return back();
        }
    }

    public function komen(Request $request){
        $request->validate([
            'id_post' => 'required',
            'nik' => 'required',
            'comment' => 'required|max:500',
        ]);

        $comment = new Comment();
        $comment->id_post = $request->id_post;
        $comment->nik = $request->nik;
        $comment->comment = $request->comment;

        if ($comment->save()) {
            toast('Berhasil Komentar.','success');
            return back();
        } else {
            toast('Gagal Komentar.','warning');
            return back();
        }
        
    }
}
