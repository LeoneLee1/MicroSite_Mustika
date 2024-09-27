<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostLike;
use App\Models\AnswerVote;
use App\Models\PollAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request){

        $user = Auth::user()->nik;
        $userRole = Auth::user()->role;

        $total_user = DB::select("SELECT COUNT(*) AS total_users FROM users;");

        $currentTime = now();

        // QUERY MYSQL
        // $postQuery = "SELECT p.*, u.nama, u.unit, u.gender, p.created_at AS time_post, l.nik AS liked 
        //           FROM posts p
        //           LEFT JOIN users u ON u.nik = p.nik
        //           LEFT JOIN post_like l ON l.id_post = p.id AND l.nik = ?
        //           WHERE 1=1";

        // $queryParams = [$user];

        // if ($userRole === "Pengamat") {
        //     $postQuery .= " AND p.created_at <= DATE_SUB(?, INTERVAL 24 HOUR)";
        //     $queryParams[] = $currentTime;
        // }

        // $postQuery .= " ORDER BY p.id DESC";

        // $post = DB::select($postQuery, $queryParams);

        // ORM QUERY
        $postQuery = DB::table('posts as p')
        ->select('p.*', 'u.nama', 'u.unit', 'u.gender','u.foto', 'p.created_at as time_post', 'l.nik as liked')
        ->leftJoin('users as u', 'u.nik', '=', 'p.nik')
        ->leftJoin('post_like as l', function($join) use ($user) {
            $join->on('l.id_post', '=', 'p.id')
                ->where('l.nik', '=', $user);
        })
        ->whereRaw('1=1');

        if ($userRole === "Pengamat") {
        $postQuery->where('p.created_at', '<=', DB::raw('DATE_SUB(?, INTERVAL 24 HOUR)', [$currentTime]));
        }

        $postQuery->orderBy('p.id', 'DESC');

        $post = $postQuery->paginate(5);


        // $post = DB::select("SELECT p.*, u.nama, u.unit,u.gender , p.created_at AS time_post, l.nik AS liked FROM posts p
        //                 LEFT JOIN users u ON u.nik = p.nik
        //                 LEFT JOIN post_like l ON l.id_post = p.id
        //                 AND l.nik = '$user'
        //                 ORDER BY p.id DESC;");
        
                        
        $komen = DB::select("SELECT c.*, u.nama FROM comments c
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

        $jawabanModal = DB::select("SELECT 
                                    pl.jawaban,
                                    pl.value, 
                                    pl.id_post,
                                    pl.poll_id,
                                    GROUP_CONCAT(a.nik SEPARATOR ', ') AS nik_list,
                                    GROUP_CONCAT(DATE_FORMAT(a.created_at, '%e/%c/%y %H:%i') ORDER BY a.created_at SEPARATOR ', ') AS time_vote
                                FROM poll_answers pl
                                LEFT JOIN answer_vote a 
                                    ON a.id_jawaban = pl.id
                                GROUP BY pl.jawaban, pl.value, pl.id_post, pl.poll_id, pl.id
										  ORDER BY pl.id ASC;");

        return view('welcome',compact('post','komen','poll','jawaban','jawabanModal','total_user','polling'));

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

        $post = Post::find($postId);

        if (!$post) {
            return response()->json(['success' => false, 'message' => 'Post not found'], 404);
        }

        $existingLike = PostLike::where('nik', $userNik)
                                    ->where('id_post', $post->id)
                                    ->first();

        if ($existingLike) {
            if ($existingLike->id_post == $postId) {
                $existingLike->delete();

                $post->like -= 1;
                $post->save();

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

            return response()->json(['success' => true, 'message' => 'Like added']);
        }
    }

}
