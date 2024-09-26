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

        $komen = DB::select("SELECT c.*, u.nama, c.id AS id_comment,p.id FROM comments c
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

    public function deleteComment($id_comment){

        $data = Comment::findOrFail($id_comment);
        $data->delete();

        toast('Berhasil Menghapus','success');

        return back();
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $posts = Post::where('judul', 'LIKE', "%{$query}%")
                    ->orWhere('deskripsi', 'LIKE', "%{$query}%")
                    ->get();
        return response()->json($posts);
    }

    public function lihat($id)
    {
        $user = Auth::user()->nik;
        $userRole = Auth::user()->role;

        $postQuery = "SELECT p.*, u.nama, u.unit, u.gender, p.created_at AS time_post, l.nik AS liked 
                FROM posts p
                LEFT JOIN users u ON u.nik = p.nik
                LEFT JOIN post_like l ON l.id_post = p.id AND l.nik = ?
                WHERE p.id = ?";

        $queryParams = [$user, $id];

        if ($userRole === "Pengamat") {
            $postQuery = "SELECT p.*, u.nama, u.unit, u.gender, p.created_at AS time_post, l.nik AS liked 
                    FROM posts p
                    LEFT JOIN users u ON u.nik = p.nik
                    LEFT JOIN post_like l ON l.id_post = p.id AND l.nik = ?
                    WHERE p.id = ? AND p.created_at <= DATE_SUB(NOW(), INTERVAL 24 HOUR)";
        }

        $data = DB::select($postQuery, $queryParams);

        // Sisa kode tetap sama
        $komen = DB::select("SELECT c.*, u.nama FROM comments c
                            LEFT JOIN users u ON u.nik = c.nik
                            ORDER BY c.id DESC");

        $poll = DB::select("SELECT pl.* FROM polls pl");

        $jawaban = DB::select("SELECT a.*, an.nik AS voted , a.value FROM poll_answers a
                LEFT JOIN polls p ON p.id = a.poll_id
                LEFT JOIN answer_vote an ON an.jawaban = a.jawaban AND an.nik = ?
                ORDER BY a.id ASC", [$user]);

        $polling = DB::select("SELECT pa.jawaban, pa.id_post, pa.poll_id, p.id, pl.id , pa.value 
                FROM poll_answers pa
                LEFT JOIN posts p ON p.id = pa.id_post
                LEFT JOIN polls pl ON pl.id = pa.poll_id
                WHERE p.id = '$id';");

        $jawabanModal = DB::select("SELECT 
                    pl.jawaban,
                    pl.value, 
                    pl.id_post,
                    pl.poll_id,
                    GROUP_CONCAT(a.nik SEPARATOR ', ') AS nik_list,
                    GROUP_CONCAT(DATE_FORMAT(a.created_at, '%e/%c/%y %H:%i') ORDER BY a.created_at SEPARATOR ', ') AS time_vote
                FROM poll_answers pl
                LEFT JOIN answer_vote a ON a.id_jawaban = pl.id
                GROUP BY pl.jawaban, pl.value, pl.id_post, pl.poll_id, pl.id
                ORDER BY pl.id ASC");

        return view('post.lihat', compact('data', 'komen', 'poll', 'jawaban', 'polling', 'jawabanModal'));
    }

}
