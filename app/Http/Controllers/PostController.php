<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\Post;
use App\Models\Comment;
use App\Models\PostLike;
use App\Models\NotifPost;
use App\Models\AnswerVote;
use App\Models\NotifBadge;
use App\Models\PollAnswer;
use App\Models\CommentLike;
use Illuminate\Http\Request;
use App\Models\NotifPostLike;
use App\Models\CommentReplies;
use App\Models\NotifPostComment;
use Illuminate\Support\Facades\DB;
use App\Models\NotifPostCommentLike;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Models\NotifPostCommentReplies;
use RealRashid\SweetAlert\Facades\Alert;
use Stichoza\GoogleTranslate\GoogleTranslate;

class PostController extends Controller
{
    public function index(){

        $nik = Auth::user()->nik;

        $notifPost = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul 
                                    FROM notif_post a
                                    LEFT JOIN users b ON b.nik = a.nik
                                    LEFT JOIN posts c ON c.id = a.id_post
                                    ORDER BY a.id DESC
                                    LIMIT 2;");
        
        $notifPostLike = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul, c.nik AS nik_post 
                                    FROM notif_post_like a
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

        $notifBadge = DB::select("SELECT * FROM notif_badge WHERE nik = '$nik'");

        $notifCommentLike = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul, d.nik AS nik_comment
                                    FROM notif_post_commentlike a
                                    LEFT JOIN users b ON b.nik = a.nik
                                    LEFT JOIN posts c ON c.id = a.id_post
                                    LEFT JOIN comments d ON d.id = a.id_comment
                                    ORDER BY a.id DESC
                                    LIMIT 1;");

        $notifCommentBalas = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul, e.nik AS nik_comment
                                    FROM notif_post_commentbalas a
                                    LEFT JOIN users b ON b.nik = a.nik
                                    LEFT JOIN posts c ON c.id = a.id_post
                                    LEFT JOIN comments_replies d ON d.id = a.id_commentReplies
                                    LEFT JOIN comments e ON e.id = a.id_comment
                                    ORDER BY a.id DESC
                                    LIMIT 1;");

        return view('post.index',compact('notifPost','notifPostLike','notifPostComment','notifBadge','notifCommentLike','notifCommentBalas'));
    }

    public function insert(Request $request){
        $request->validate([
            'nik' => 'required',
            'judul' => 'required',
            'deskripsi' => 'required',
        ]);

        $post = new Post();
        $post->nik = $request->nik;
        $post->judul = $request->judul;
        $post->media = $request->media;
        $post->deskripsi = $request->deskripsi;

        if ($request->hasFile('media_file')) {
            $file = $request->file('media_file');
            $fileExtension = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $fileExtension;

            $filePath = public_path('media/' . $fileName);

            if (in_array($fileExtension, ['jpg','jpeg','png','gif'])) {
                $img = Image::make($file);
                $img->resize(700, 700,function ($constraint){
                $constraint->aspectRatio();
                $constraint->upsize();
                })->save($filePath);

                $post->media_file = $fileName;
            } elseif(in_array($fileExtension,['mp4','webm','ogg'])){
                $file->move(public_path('media/'),$fileName);
                $post->media_file = $fileName;
            }    
            
        }
        
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

        $userNik = Auth::user()->nik;
        
        $post = Post::findOrFail($id);

        $komen = DB::select("SELECT c.*, CASE WHEN u.role = 'Anonymous' THEN 'NoName' WHEN u.role = 'admin' THEN 'INSAN MUSTIKA' ELSE u.nama END AS nama, u.foto,c.id, p.id AS post_id, cl.nik AS liked, u.unit, u.gender, u.ap FROM comments c
                        LEFT JOIN users u ON u.nik = c.nik
                        LEFT JOIN posts p ON p.id = c.id_post
                        LEFT JOIN comments_likes cl ON cl.id_comment = c.id
                        AND cl.nik = '$userNik'
                        WHERE p.id = '$id'
                        ORDER BY c.created_at DESC;");

        $replies = DB::select("SELECT cr.*, CASE WHEN u.role = 'Anonymous' THEN 'NoName' WHEN u.role = 'admin' THEN 'INSAN MUSTIKA' ELSE u.nama END AS nama,u.foto, c.id AS comment_id, cl.nik AS liked, u.unit, u.gender, u.ap FROM comments_replies cr
                                LEFT JOIN users u ON u.nik = cr.nik
                                LEFT JOIN comments c ON c.id = cr.id_comment
                                LEFT JOIN comments_likes cl ON cl.id_comment = cr.id
                                AND cl.nik = '$userNik'
                                ORDER BY cr.id DESC;");

        $countReplies = DB::select("SELECT COUNT(id_comment) AS total, id_comment FROM comments_replies
                                    GROUP BY id_comment;");

        $commentLike = DB::select("SELECT cl.*, CASE WHEN u.role = 'Anonymous' THEN 'NoName' WHEN u.role = 'admin' THEN 'INSAN MUSTIKA' ELSE u.nama END AS nama, u.foto FROM comments_likes cl
                                LEFT JOIN users u ON u.nik = cl.nik;");

        $notifPost = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul 
                                    FROM notif_post a
                                    LEFT JOIN users b ON b.nik = a.nik
                                    LEFT JOIN posts c ON c.id = a.id_post
                                    ORDER BY a.id DESC
                                    LIMIT 2;");

        $notifPostLike = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul, c.nik AS nik_post 
                                    FROM notif_post_like a
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

        $notifBadge = DB::select("SELECT * FROM notif_badge WHERE nik = '$userNik'");

        $notifCommentLike = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul, d.nik AS nik_comment
                                    FROM notif_post_commentlike a
                                    LEFT JOIN users b ON b.nik = a.nik
                                    LEFT JOIN posts c ON c.id = a.id_post
                                    LEFT JOIN comments d ON d.id = a.id_comment
                                    ORDER BY a.id DESC
                                    LIMIT 1;");

        $notifCommentBalas = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul, e.nik AS nik_comment
                                    FROM notif_post_commentbalas a
                                    LEFT JOIN users b ON b.nik = a.nik
                                    LEFT JOIN posts c ON c.id = a.id_post
                                    LEFT JOIN comments_replies d ON d.id = a.id_commentReplies
                                    LEFT JOIN comments e ON e.id = a.id_comment
                                    ORDER BY a.id DESC
                                    LIMIT 1;");

        return view('post.komentar',compact('post','komen','replies','countReplies','commentLike','notifPost','notifPostLike','notifPostComment','notifBadge','notifCommentLike','notifCommentBalas'));
    }

    public function komen(Request $request){
        $request->validate([
            'id_post' => 'required',
            'nik' => 'required',
            'comment' => 'required',
        ]);

        $k = new Comment();
        $k->id_post = $request->id_post;
        $k->nik = $request->nik;
        $k->comment = $request->comment;
        $k->save();

        $value = Post::findOrFail($request->id_post);
        $value->komen += 1;
        $value->save();

        $notifBadge = NotifBadge::where('nik',$value->nik)->first();
        $notifBadge->value += 1;
        $notifBadge->save();

        $notifKomen = new NotifPostComment();
        $notifKomen->id_post = $request->id_post;
        $notifKomen->nik = $request->nik;
        $notifKomen->id_comment = $k->id;
        $notifKomen->save();
        
        return response()->json($k);
    }

    public function deleteComment($id_comment){

        $data = Comment::findOrFail($id_comment);
        $data->delete();

        $value = Post::findOrFail($data->id_post);
        $value->komen -= 1;
        $value->save();

        $notifBadge = NotifBadge::where('nik',$value->nik)->first();
        if ($notifBadge->value == 0) {
            $notifBadge->value = 0;
            $notifBadge->save();
        } else {
            $notifBadge->value -= 1;
            $notifBadge->save();
        }

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

        $postQuery = "SELECT p.*, CASE WHEN u.role = 'Anonymous' THEN 'NoName' WHEN u.role = 'admin' THEN 'INSAN MUSTIKA' ELSE u.nama END AS nama, u.unit, u.ap, u.gender,u.foto, p.created_at AS time_post, l.nik AS liked 
                FROM posts p
                LEFT JOIN users u ON u.nik = p.nik
                LEFT JOIN post_like l ON l.id_post = p.id AND l.nik = ?
                WHERE p.id = ?";

        $queryParams = [$user, $id];

        if ($userRole === "Pengamat") {
            $postQuery = "SELECT p.*, CASE WHEN u.role = 'Anonymous' THEN 'NoName' WHEN u.role = 'admin' THEN 'INSAN MUSTIKA' ELSE u.nama END AS nama, u.unit, u.ap, u.gender,u.foto, p.created_at AS time_post, l.nik AS liked 
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

        $notifPost = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul 
                                    FROM notif_post a
                                    LEFT JOIN users b ON b.nik = a.nik
                                    LEFT JOIN posts c ON c.id = a.id_post
                                    ORDER BY a.id DESC
                                    LIMIT 2;");

        $notifPostLike = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul, c.nik AS nik_post 
                                    FROM notif_post_like a
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

        $notifBadge = DB::select("SELECT * FROM notif_badge WHERE nik = '$user'");

        $notifCommentLike = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul, d.nik AS nik_comment
                                    FROM notif_post_commentlike a
                                    LEFT JOIN users b ON b.nik = a.nik
                                    LEFT JOIN posts c ON c.id = a.id_post
                                    LEFT JOIN comments d ON d.id = a.id_comment
                                    ORDER BY a.id DESC
                                    LIMIT 1;");

        $notifCommentBalas = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul, e.nik AS nik_comment
                                    FROM notif_post_commentbalas a
                                    LEFT JOIN users b ON b.nik = a.nik
                                    LEFT JOIN posts c ON c.id = a.id_post
                                    LEFT JOIN comments_replies d ON d.id = a.id_commentReplies
                                    LEFT JOIN comments e ON e.id = a.id_comment
                                    ORDER BY a.id DESC
                                    LIMIT 1;");

        return view('post.lihat', compact('data', 'komen', 'poll', 'jawaban', 'polling', 'jawabanModal','notifPost','notifPostLike','notifPostComment','notifBadge','notifCommentLike','notifCommentBalas'));
    }

    public function edit($id){
        
        $post = Post::findOrFail($id);

        $poll = DB::select("SELECT * FROM polls
                            WHERE id_post = '$id';");

        $jawaban = DB::select("SELECT * FROM poll_answers
                                WHERE id_post = '$id';");

        $nik = Auth::user()->nik;

        $notifPost = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul FROM notif_post a
                                LEFT JOIN users b ON b.nik = a.nik
                                LEFT JOIN posts c ON c.id = a.id_post
                                ORDER BY a.id DESC
                                LIMIT 2;");

        $notifPostLike = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul, c.nik AS nik_post 
                                    FROM notif_post_like a
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

        $notifBadge = DB::select("SELECT * FROM notif_badge WHERE nik = '$nik'");

        $notifCommentLike = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul, d.nik AS nik_comment
                                    FROM notif_post_commentlike a
                                    LEFT JOIN users b ON b.nik = a.nik
                                    LEFT JOIN posts c ON c.id = a.id_post
                                    LEFT JOIN comments d ON d.id = a.id_comment
                                    ORDER BY a.id DESC
                                    LIMIT 1;");

        $notifCommentBalas = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul, e.nik AS nik_comment
                                    FROM notif_post_commentbalas a
                                    LEFT JOIN users b ON b.nik = a.nik
                                    LEFT JOIN posts c ON c.id = a.id_post
                                    LEFT JOIN comments_replies d ON d.id = a.id_commentReplies
                                    LEFT JOIN comments e ON e.id = a.id_comment
                                    ORDER BY a.id DESC
                                    LIMIT 1;");

        return view('post.edit',compact('post','poll','jawaban','notifPost','notifPostLike','notifPostComment','notifBadge','notifCommentLike','notifCommentBalas'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
        ]);

        $data = Post::findOrFail($id);
        $data->judul = $request->judul;
        $data->media = $request->media;
        $data->deskripsi = $request->deskripsi;

        if ($request->hasFile('media_file')) {
            if ($data->media_file) {
                $oldFilePath = public_path('media/' . $data->media_file);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
            
            if ($request->hasFile('media_file')) {
                $file = $request->file('media_file');
                $fileExtension = $file->getClientOriginalExtension();
                $fileName = time() . '.' . $fileExtension;
            
                $filePath = public_path('media/' . $fileName);
            
                if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                    $img = Image::make($file);
                    $img->resize(700, 700, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save($filePath);
            
                    $data->media_file = $fileName;
                    $data->media = null;
                } elseif (in_array($fileExtension, ['mp4', 'webm', 'ogg'])) {
                    $file->move(public_path('media/'), $fileName);
                    $data->media_file = $fileName;
                    $data->media = null;
                } elseif (in_array($fileExtension, ['pdf', 'xlsx', 'xls', 'xlsb', 'dotx', 'txt', 'docx'])) {
                    $file->move(public_path('media/'), $fileName);
                    $data->media_file = $fileName;
                    $data->media = null;
                }
            }
        } else {
            if ($data->media_file) {
                $oldFilePath = public_path('media/'. $data->media_file);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
                $data->media_file = null;
            }
        }

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

        $comment = Comment::where('id',$request->id_comment)->first();

        $notifBadge = NotifBadge::where('nik',$comment->nik)->first();
        $notifBadge->value += 1;
        $notifBadge->save();

        $value = Post::findOrFail($request->id_post);
        $value->komen += 1;
        $value->save();

        $notifKomen = new NotifPostCommentReplies();
        $notifKomen->id_post = $request->id_post;
        $notifKomen->nik = $request->nik;
        $notifKomen->id_commentReplies = $data->id;
        $notifKomen->id_comment = $data->id_comment;
        $notifKomen->save();

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

        $notifBadge = NotifBadge::where('nik',$comment->nik)->first();

        if ($existingLike) {
            if ($existingLike->id_comment == $id) {
                $existingLike->delete();

                $comment->likes -= 1;
                $comment->save();

                $notifLike1 = NotifPostCommentLike::where('nik',$userNik)
                                                    ->where('id_post',$comment->id_post)
                                                    ->first();

                $notifLike1->delete();

                if ($notifBadge->value == 0) {
                    $notifBadge->value = 0;
                    $notifBadge->save();
                } else {
                    $notifBadge->value -= 1;
                    $notifBadge->save();
                }

                // return response()->json(['success' => true, 'message' => 'Like removed']);
                return redirect()->back();
            } else {
                $oldLike = Comment::find($existingLike->id_comment);
                if ($oldLike) {
                    $oldLike->likes -= 1;
                    $oldLike->save();
                }

                $existingLike->id_comment = $id;
                $existingLike->comment = $comment->comment;
                $existingLike->id_post = $comment->id_post;
                $existingLike->save();

                $comment->likes += 1;
                $comment->save();

                // return response()->json(['success' => true, 'message' => 'Like updated']);
                return redirect()->back();
            }
        } else {
            CommentLike::create([
                'nik' => $userNik,
                'id_comment' => $id,
                'id_post' => $comment->id_post,
                'comment' => $comment->comment,
            ]);

            $comment->likes += 1;
            $comment->save();

            $notifLike2 = new NotifPostCommentLike();
            $notifLike2->id_post = $comment->id_post;
            $notifLike2->nik = $userNik;
            $notifLike2->id_comment = $comment->id;
            $notifLike2->save();

            $notifBadge->value += 1;
            $notifBadge->save();

            // return response()->json(['success' => true, 'message' => 'Like added']);
            return redirect()->back();
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

    public function delete($id){
        $post = Post::findOrFail($id);

        if ($post->media_file) {
            $oldFilePath = public_path('media/'.$post->media_file);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }
        
        if ($post->delete()) {
            $comment = Comment::where('id_post',$id)->delete();
            $commentReplies = CommentReplies::where('id_post',$id)->delete();
            $commentLike = CommentLike::where('id_post',$id)->delete();
            $like = PostLike::where('id_post',$id)->delete();
            $poll = Poll::where('id_post',$id)->delete();
            $pollAnswer = PollAnswer::where('id_post',$id)->delete();
            $answerVote = AnswerVote::where('id_post',$id)->delete();
            $notif1 = NotifPost::where('id_post',$id)->delete();
            $notif2 = NotifPostLike::where('id_post',$id)->delete();
            $notif3 = NotifPostComment::where('id_post',$id)->delete();
            $notif4 = NotifPostCommentLike::where('id_post',$id)->delete();
            $notif5 = NotifPostCommentReplies::where('id_post',$id)->delete();

            $notifBadge = NotifBadge::all();
            foreach ($notifBadge as $item){
                $item->value = 0;
                $item->save();
            }

            Alert::success('Berhasil menghapus');
            return redirect()->back();
        } else {
            Alert::error('Gagal menghapus');
            return redirect()->back();
        }
        
    }

    public function deleteKomen($id){
        $komen = Comment::findOrFail($id);
        
        if ($komen->delete()) {
            $komenBalas = CommentReplies::where('id_comment',$id)->delete();
            $komenSuka = CommentLike::where('id_comment',$id)->delete();
            Alert::success('Berhasil Menghapus Komentar');
            return redirect()->back();
        } else {
            Alert::error('Gagal Menghapus Komentar');
            return redirect()->back();
        }
    }

}
