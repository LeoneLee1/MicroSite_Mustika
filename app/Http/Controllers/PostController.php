<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'deskripsi' => 'required|max:1000',
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

    public function viewComment($id){
        
        $post = Post::findOrFail($id);

        $komen = DB::select("SELECT c.*, u.nama, u.foto,p.id FROM comments c
                        LEFT JOIN users u ON u.nik = c.nik
                        LEFT JOIN posts p ON p.id = c.id_post 
                        WHERE p.id = '$id'
                        ORDER BY c.id DESC;");

        return view('post.komentar',compact('post','komen'));
    }

    public function komen(Request $request){
        $request->validate([
            'id_post' => 'required',
            'nik' => 'required',
            'comment' => 'required|max:500',
        ]);

        $k = new Comment();
        $k->id_post = $request->id_post;
        $k->nik = $request->nik;
        $k->comment = $request->comment;
        $k->save();
        
        return response()->json($k);
    }

}
