<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\Post;
use App\Models\Notif;
use App\Models\Comment;
use App\Models\PollAnswer;
use App\Models\CommentLike;
use Illuminate\Http\Request;
use App\Models\CommentReplies;
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
            'deskripsi' => 'required|max:1001',
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
            $data = new Notif();
            $data->id_user = Auth::user()->id;
            $data->id_post = $post->id;
            $data->deskripsi = 'Membagikan Postingan';
            $data->save();
            return back();
        } else {
            Alert::error('Gagal!','Membuat Post, Mohon Coba Lagi.');
            return back();
        }
    }

    public function viewComment($id){

        $userNik = Auth::user()->nik;
        
        $post = Post::findOrFail($id);

        $komen = DB::select("SELECT c.*, CASE WHEN u.role = 'Anonymous' THEN 'NoName' WHEN u.role = 'admin' THEN 'INSAN MUSTIKA' ELSE u.nama END AS nama, u.foto,c.id, p.id AS post_id, cl.nik AS liked FROM comments c
                        LEFT JOIN users u ON u.nik = c.nik
                        LEFT JOIN posts p ON p.id = c.id_post
                        LEFT JOIN comments_likes cl ON cl.id_comment = c.id
                        AND cl.nik = '$userNik'
                        WHERE p.id = '$id'
                        ORDER BY c.created_at DESC;");

        $replies = DB::select("SELECT cr.*, CASE WHEN u.role = 'Anonymous' THEN 'NoName' WHEN u.role = 'admin' THEN 'INSAN MUSTIKA' ELSE u.nama END AS nama,u.foto, c.id AS comment_id, cl.nik AS liked FROM comments_replies cr
                                LEFT JOIN users u ON u.nik = cr.nik
                                LEFT JOIN comments c ON c.id = cr.id_comment
                                LEFT JOIN comments_likes cl ON cl.id_comment = cr.id
                                AND cl.nik = '$userNik'
                                ORDER BY cr.id DESC;");

        $countReplies = DB::select("SELECT COUNT(id_comment) AS total, id_comment FROM comments_replies
                                    GROUP BY id_comment;");

        $commentLike = DB::select("SELECT cl.*, CASE WHEN u.role = 'Anonymous' THEN 'NoName' WHEN u.role = 'admin' THEN 'INSAN MUSTIKA' ELSE u.nama END AS nama, u.foto FROM comments_likes cl
                                LEFT JOIN users u ON u.nik = cl.nik;");

        return view('post.komentar',compact('post','komen','replies','countReplies','commentLike'));
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

        $value = Post::findOrFail($request->id_post);
        $value->komen += 1;
        $value->save();
        
        return response()->json($k);
    }

    public function deleteComment($id_comment){

        $data = Comment::findOrFail($id_comment);
        $data->delete();

        $value = Post::findOrFail($data->id_post);
        $value->komen -= 1;
        $value->save();

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

        $postQuery = "SELECT p.*, CASE WHEN u.role = 'Anonymous' THEN 'NoName' WHEN u.role = 'admin' THEN 'INSAN MUSTIKA' ELSE u.nama END AS nama, u.unit, u.gender,u.foto, p.created_at AS time_post, l.nik AS liked 
                FROM posts p
                LEFT JOIN users u ON u.nik = p.nik
                LEFT JOIN post_like l ON l.id_post = p.id AND l.nik = ?
                WHERE p.id = ?";

        $queryParams = [$user, $id];

        if ($userRole === "Pengamat") {
            $postQuery = "SELECT p.*, CASE WHEN u.role = 'Anonymous' THEN 'NoName' WHEN u.role = 'admin' THEN 'INSAN MUSTIKA' ELSE u.nama END AS nama, u.unit, u.gender,u.foto, p.created_at AS time_post, l.nik AS liked 
                    FROM posts p
                    LEFT JOIN users u ON u.nik = p.nik
                    LEFT JOIN post_like l ON l.id_post = p.id AND l.nik = ?
                    WHERE p.id = ? AND p.created_at <= DATE_SUB(NOW(), INTERVAL 24 HOUR)";
        }

        $data = DB::select($postQuery, $queryParams);

        // Sisa kode tetap sama
        $komen = DB::select("SELECT c.*, CASE WHEN u.role = 'Anonymous' THEN 'NoName' WHEN u.role = 'admin' THEN 'INSAN MUSTIKA' ELSE u.nama END AS nama FROM comments c
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

    public function edit($id){
        
        $post = Post::findOrFail($id);

        $poll = DB::select("SELECT * FROM polls
                            WHERE id_post = '$id';");

        $jawaban = DB::select("SELECT * FROM poll_answers
                                WHERE id_post = '$id';");

        return view('post.edit',compact('post','poll','jawaban'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'judul' => 'required',
            'media' => 'required',
            'deskripsi' => 'required',
        ]);

        $data = Post::findOrFail($id);
        $data->judul = $request->judul;
        $data->media = $request->media;
        $data->deskripsi = $request->deskripsi;

        if ($data->save()) {
            Alert::success('Berhasil!','Mengubah Post.');
            return back();
        } else {
            Alert::error('Gagal!','Mengubah Post.');
            return back();
        }
    }

    public function repliesComment(Request $request){
        $request->validate([
            'id_post' => 'required',
            'id_comment' => 'required',
            'nik' => 'required',
            'comment' => 'required',
        ]);

        $data = new CommentReplies();
        $data->id_post = $request->id_post;
        $data->id_comment = $request->id_comment;
        $data->nik = $request->nik;
        $data->comment = $request->comment;
        $data->save();

        $value = Post::findOrFail($request->id_post);
        $value->komen += 1;
        $value->save();

        return response()->json($data);

    }

    public function likeComments(Request $request, $id){
        $userNik = Auth::user()->nik;

        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json(['success' => false, 'message' => 'Post not found'], 404);
        }

        $existingLike = CommentLike::where('nik',$userNik)
                                    ->where('id_comment',$comment->id)
                                    ->first();

        if ($existingLike) {
            if ($existingLike->id_comment == $id) {
                $existingLike->delete();

                $comment->likes -= 1;
                $comment->save();

                return response()->json(['success' => true, 'message' => 'Like removed']);
            } else {
                $oldLike = Comment::find($existingLike->id_comment);
                if ($oldLike) {
                    $oldLike->likes -= 1;
                    $oldLike->save();
                }

                $existingLike->id_comment = $id;
                $existingLike->comment = $comment->comment;
                $existingLike->save();

                $comment->likes += 1;
                $comment->save();

                return response()->json(['success' => true, 'message' => 'Like updated']);
            }
        } else {
            CommentLike::create([
                'nik' => $userNik,
                'id_comment' => $id,
                'comment' => $comment->comment,
            ]);

            $comment->likes += 1;
            $comment->save();

            return response()->json(['success' => true, 'message' => 'Like added']);
        }
    }

    public function likeCommentsReplies(Request $request, $id){
        $userNik = Auth::user()->nik;

        $comment = CommentReplies::find($id);

        if (!$comment) {
            return response()->json(['success' => false, 'message' => 'Post not found'], 404);
        }

        $existingLike = CommentLike::where('nik',$userNik)
                                    ->where('id_comment',$comment->id)
                                    ->first();

        if ($existingLike) {
            if ($existingLike->id_comment == $id) {
                $existingLike->delete();

                $comment->likes -= 1;
                $comment->save();

                return response()->json(['success' => true, 'message' => 'Like removed']);
            } else {
                $oldLike = CommentReplies::find($existingLike->id_comment);
                if ($oldLike) {
                    $oldLike->likes -= 1;
                    $oldLike->save();
                }

                $existingLike->id_comment = $id;
                $existingLike->comment = $comment->comment;
                $existingLike->save();

                $comment->likes += 1;
                $comment->save();

                return response()->json(['success' => true, 'message' => 'Like updated']);
            }
        } else {
            CommentLike::create([
                'nik' => $userNik,
                'id_comment' => $id,
                'comment' => $comment->comment,
            ]);

            $comment->likes += 1;
            $comment->save();

            return response()->json(['success' => true, 'message' => 'Like added']);
        }
    }

    // public function updateSoal(Request $request, $id_post){
    //     $request->validate([
    //         'soal' => 'required',
    //     ]);

    //     $data = Poll::findOrFail($id_post);
    //     $data->soal = $request->soal;

    //     if ($data->save()) {
    //         Alert::success('Berhasil!', 'Soal polling telah diperbarui.');
    //         return back();
    //     } else {
    //         Alert::error('Gagal!', 'Soal polling gagal diperbarui.');
    //         return back();
    //     }
    // }

    // public function updateJawaban(Request $request, $id_post){
    //     $request->validate([
    //         'jawaban' => 'required',
    //     ]);

    //     $data = DB::select("SELECT * FROM poll_answers
    //                         WHERE id_post = '$id_post'");
    //     $data->jawaban = $request->jawaban;

    //     if ($data->save()) {
    //         Alert::success('Berhasil!', 'Jawaban polling telah diperbarui.');
    //         return back();
    //     } else {
    //         Alert::error('Gagal!', 'Jawaban polling gagal diperbarui.');
    //         return back();
    //     }
    // }

    public function delete($id){
        //
    }

}
