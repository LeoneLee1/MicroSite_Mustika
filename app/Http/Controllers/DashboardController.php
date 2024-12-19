<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Save;
use App\Models\PostLike;
use App\Models\AnswerVote;
use App\Models\NotifBadge;
use App\Models\PollAnswer;
use Illuminate\Http\Request;
use App\Models\NotifPostLike;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class DashboardController extends Controller
{
    public function index(Request $request){

        $user = Auth::user()->nik;
        $userId = Auth::user()->id;
        $userRole = Auth::user()->role;
        $currentTime = Carbon::now();
        
        // ORM QUERY
        $postQuery = DB::table('posts as p')
        ->select(
            'p.*', 
            DB::raw("CASE WHEN u.role = 'Anonymous' THEN 'NoName' WHEN u.role = 'admin' THEN 'INSAN MUSTIKA' ELSE u.nama END AS nama"),
            'u.unit', 
            'u.ap', 
            'u.gender', 
            'u.foto', 
            'p.created_at as time_post',
            'l.nik as liked'
        )
        ->leftJoin('users as u', 'u.nik', '=', 'p.nik')
        ->leftJoin('post_like as l', function($join) use ($user) {
            $join->on('l.id_post', '=', 'p.id')
                ->where('l.nik', '=', $user);
        })
        ->whereRaw('1=1');

        if ($userRole === "Pengamat") {
            $postQuery->where('p.created_at', '<=', DB::raw("DATE_SUB('" . $currentTime . "', INTERVAL 24 HOUR)"));
        }

        $postQuery->orderBy('p.id', 'desc');

        $post = $postQuery->paginate(15);
        // $post = $postQuery->get();
        
        $komen = DB::select("SELECT c.*, CASE WHEN u.role = 'Anonymous' THEN 'NoName' WHEN u.role = 'admin' THEN 'INSAN MUSTIKA' ELSE u.nama END AS nama, u.foto FROM comments c
                        LEFT JOIN users u ON u.nik = c.nik
                        ORDER BY c.id DESC;");

        $poll = DB::select("SELECT pl.* FROM polls pl;");

        $jawaban = DB::select("SELECT a.*, an.nik AS voted , a.value FROM poll_answers a
                                LEFT JOIN polls p ON p.id = a.poll_id
                                LEFT JOIN answer_vote an ON an.jawaban = a.jawaban
                                AND an.nik = '$user'
                                ORDER BY a.id ASC;");

        $polling = DB::select("SELECT pa.jawaban,pa.id_post, pa.poll_id, p.id, pl.id , pa.value FROM poll_answers pa
                                LEFT JOIN posts p ON p.id = pa.id_post
                                LEFT JOIN polls pl ON pl.id = pa.poll_id;");

        $postLike = DB::select("SELECT pl.*, CASE WHEN u.role = 'Anonymous' THEN 'NoName' WHEN u.role = 'admin' THEN 'INSAN MUSTIKA' ELSE u.nama END AS nama, u.foto, p.judul FROM post_like pl
                                LEFT JOIN users u ON u.nik = pl.nik
                                LEFT JOIN posts p ON p.id = pl.id_post;");

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

        $notifPostComment = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul, c.nik AS nik_post FROM notif_post_comment a
                                    LEFT JOIN users b ON b.nik = a.nik
                                    LEFT JOIN posts c ON c.id = a.id_post
                                    ORDER BY a.id DESC
                                    LIMIT 1;");

        $notifBadge = DB::select("SELECT * FROM notif_badge WHERE nik = '$user'");

        $existingNotifBadgeNik = NotifBadge::where('nik',$user)->first();

        if ($existingNotifBadgeNik) {
            //
        } else {
            NotifBadge::create([
                'nik' => $user,
            ]);
        }

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
        
        return view('welcome',compact('post','komen','poll','jawaban','polling','postLike','notifPost','notifPostLike','notifPostComment','notifBadge','notifCommentLike','notifCommentBalas'));

    }

    public function chart($id){
        $data = DB::select("SELECT a.* FROM poll_answers a
                            LEFT JOIN polls p ON p.id = a.poll_id
                            WHERE p.id = '$id'
                            ORDER BY a.id ASC;");

        return response()->json($data);
    }

    public function like($postId, Request $request){
        $userNik = Auth::user()->nik;

        $time = Carbon::now();

        $post = Post::find($postId);

        if (!$post) {
            return response()->json(['success' => false, 'message' => 'Post not found'], 404);
        }

        $existingLike = PostLike::where('nik', $userNik)
                                    ->where('id_post', $post->id)
                                    ->first();

        $notifBadge = NotifBadge::where('nik',$post->nik)->first();

        if ($existingLike) {
            if ($existingLike->id_post == $postId) {
                $existingLike->delete();

                $post->like -= 1;
                $post->save();

                $notifLike1 = NotifPostLike::where('nik',$userNik)
                                            ->where('id_post',$postId)
                                            ->first();

                $notifLike1->delete();

                if ($notifBadge->value == 0) {
                    $notifBadge->value = 0;
                    $notifBadge->save();
                } else {
                    $notifBadge->value -= 1;
                    $notifBadge->save();
                }

                return response()->json(['success' => true, 'message' => 'Like removed']);
            } else {

                $oldLike = Post::find($existingLike->id_post);
                if ($oldLike) {
                    $oldLike->like -= 1;
                    $oldLike->save();
                }
                
                $existingLike->id_post = $postId;
                $existingLike->judul = $post->judul;
                $existingLike->save();

                $post->like += 1;
                $post->save();

                return response()->json(['success' => true, 'message' => 'Like updated']);

            }
        } else {
            PostLike::create([
                'nik' => $userNik,
                'id_post' => $postId,
                'judul' => $post->judul,
            ]);

            $post->like += 1;
            $post->save();

            $notifLike2 = new NotifPostLike();
            $notifLike2->id_post = $postId;
            $notifLike2->nik = $userNik;
            $notifLike2->save();

            $notifBadge->value += 1;
            $notifBadge->save();

            return response()->json(['success' => true, 'message' => 'Like added']);
        }
    }

    public function save(Request $request,$id){
        $userNik = Auth::user()->nik;

        $time = Carbon::now();
        
        $existingSave = Save::where('nik',$userNik)
                                    ->where('id_post',$id)
                                    ->first();

        if ($existingSave) {
            return response()->json(['error' => true, 'message' => 'Postingan ini sudah disaved']);
        } else {
            Save::create([
                'id_post' => $id,
                'nik' => $userNik,
                'created_at' => $time,
                'updated_at' => $time,
            ]);

            return response()->json(['success' => true, 'message' => 'Saved Post']);
        }

    }

    public function viewVote($id){

        $user = Auth::user()->nik;

        $post = DB::select("SELECT p.*, u.nama, u.unit,u.gender , p.created_at AS time_post, l.nik AS liked FROM posts p
                        LEFT JOIN users u ON u.nik = p.nik
                        LEFT JOIN post_like l ON l.id_post = p.id
                        AND l.nik = '$user'
                        ORDER BY p.id DESC;");

        $poll = DB::select("SELECT * FROM polls
                            WHERE id = '$id';");

        $jawabanModal = DB::select("SELECT 
                                    pl.id,pl.jawaban, pl.value, pl.id_post, pl.poll_id,
                                    GROUP_CONCAT(CASE WHEN u.role = 'Anonymous' THEN 'NoName' WHEN u.role = 'admin' THEN 'INSAN MUSTIKA' ELSE u.nama END SEPARATOR ', ') AS nik_list,
                                    GROUP_CONCAT(DATE_FORMAT(a.created_at, '%e/%c/%y %H:%i') ORDER BY a.created_at SEPARATOR ', ') AS time_vote
                                    FROM poll_answers pl
                                    LEFT JOIN answer_vote a ON a.id_jawaban = pl.id
                                    LEFT JOIN users u ON u.nik = a.nik
                                    GROUP BY pl.jawaban, pl.value, pl.id_post, pl.poll_id, pl.id
                                    ORDER BY pl.id ASC;");
        
        $answer_vote = DB::select("SELECT * FROM answer_vote;");

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

        $notifPostComment = DB::select("SELECT a.*, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul, c.nik AS nik_post FROM notif_post_comment a
                                    LEFT JOIN users b ON b.nik = a.nik
                                    LEFT JOIN posts c ON c.id = a.id_post
                                    ORDER BY a.id DESC
                                    LIMIT 1;");

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

        return view('polling.viewVotes',compact('poll','jawabanModal','post','answer_vote','notifPost','notifPostLike','notifPostComment','notifCommentLike','notifCommentBalas'));
    }

    public function viewNotification(){

        $post = DB::select("SELECT * FROM notif_post ORDER BY id DESC;");
        $postLike = DB::select("SELECT * FROM notif_post_like ORDER BY id DESC;");
        $postComment = DB::select("SELECT * FROM notif_post_comment ORDER BY id DESC;");

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

        $notif_post_all = DB::select("SELECT a.id, a.id_post, a.created_at , a.updated_at, a.info, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul, NULL AS comment, NULL AS commentReplies, NULL AS jawaban
                                        FROM notif_post a
                                        LEFT JOIN users b on b.nik = a.nik
                                        LEFT JOIN posts c ON c.id = a.id_post
                                        UNION ALL
                                        SELECT a.id, a.id_post, a.created_at , a.updated_at, a.info, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, c.judul, NULL AS comment, NULL AS commentReplies, NULL AS jawaban
                                        FROM notif_post_like a
                                        LEFT JOIN users b on b.nik = a.nik
                                        LEFT JOIN posts c ON c.id = a.id_post
                                        WHERE c.nik = '$nik'
                                        UNION ALL
                                        SELECT a.id, a.id_post, a.created_at , a.updated_at, a.info, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, NULL AS judul, d.comment, NULL AS commentReplies, NULL AS jawaban
                                        FROM notif_post_comment a
                                        LEFT JOIN users b on b.nik = a.nik
                                        LEFT JOIN posts c ON c.id = a.id_post
                                        LEFT JOIN comments d ON d.id = a.id_comment
                                        WHERE c.nik = '$nik'
                                        UNION ALL
                                        SELECT a.id, a.id_post, a.created_at , a.updated_at, a.info, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, NULL AS judul, NULL AS comment, d.comment AS commentReplies, NULL AS jawaban
                                        FROM notif_post_commentbalas a
                                        LEFT JOIN users b on b.nik = a.nik
                                        LEFT JOIN posts c ON c.id = a.id_post
                                        LEFT JOIN comments_replies d ON d.id = a.id_commentReplies
                                        LEFT JOIN comments e ON e.id = d.id_comment
                                        WHERE e.nik = '$nik'
                                        UNION ALL
                                        SELECT a.id, a.id_post, a.created_at , a.updated_at, a.info, CASE WHEN b.role = 'Anonymous' THEN 'NoName' WHEN b.role = 'admin' THEN 'INSAN MUSTIKA' ELSE b.nama END AS nama, b.foto, NULL AS judul, d.comment, NULL AS commentReplies, NULL AS jawaban
                                        FROM notif_post_commentlike a
                                        LEFT JOIN users b on b.nik = a.nik
                                        LEFT JOIN posts c ON c.id = a.id_post
                                        LEFT JOIN comments d ON d.id = a.id_comment
                                        WHERE d.nik = '$nik'
                                        ORDER BY created_at DESC");

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

        return view('notifications',compact('post','postLike','postComment','notifPost','notifPostLike','notifPostComment','notif_post_all','notifBadge','notifCommentLike','notifCommentBalas'));
    }

    public function insertNomorHp(Request $request){
        $request->validate([
            'no_hp' => 'required',
        ]);

        $auth = Auth::user();
        $auth->no_hp = $this->no_wa($request->no_hp);

        if ($auth->save()) {
            Alert::success('Terima kasih atas kerja sama-nya.');
            return redirect()->back();
        } else {
            Alert::error('Mohon dicoba lagi.');
            return redirect()->back();
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

}
