<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function index(){
        return view('activity.index');
    }

    public function likes(){

        $userNik = Auth::user()->nik;

        // $likes = DB::select("SELECT pl.*, p.judul, p.media FROM post_like pl
        //                     LEFT JOIN posts p ON p.id = pl.id_post
        //                     WHERE pl.nik = '$userNik'
        //                     ORDER BY pl.id DESC;");

        $likes = DB::table('post_like as pl')
                ->select('pl.*', 'p.judul', 'p.media')
                ->leftJoin('posts as p', 'p.id', '=', 'pl.id_post')
                ->where('pl.nik', '=', $userNik)
                ->orderBy('pl.id', 'desc')
                ->paginate(5);

        return view('activity.likes',compact('likes'));
    }

    public function comments(){

        $userNik = Auth::user()->nik;

        $comments = DB::select("SELECT c.*, c.comment AS komen, p.nik AS nik_post , p.judul , CASE WHEN u.role = 'Anonymous' THEN 'NoName' ELSE u.nama END AS nama, u.foto AS foto_post
                                FROM comments c
                                LEFT JOIN posts p ON p.id = c.id_post
                                LEFT JOIN users u ON u.nik = p.nik
                                WHERE c.nik = '$userNik'
                                ORDER BY c.id DESC;");

        return view('activity.comments',compact('comments'));
        
    }

    public function posts(){

        $user = Auth::user()->nik;

        $post = DB::select("SELECT * FROM posts
                            WHERE nik = '$user'
                            ORDER BY id DESC;");

        return view('activity.posts',compact('post'));
    }

    public function voting(){

        $user = Auth::user()->nik;

        $voting = DB::select("SELECT a.*, p.judul, p.media , s.soal, pl.id_post AS post_id
                                FROM answer_vote a
                                LEFT JOIN poll_answers pl ON pl.id = a.id_jawaban
                                LEFT JOIN polls s ON s.id = a.poll_id
                                LEFT JOIN posts p ON p.id = pl.id_post
                                WHERE a.nik = '$user'
                                ORDER BY a.id DESC;");
    
        return view('activity.voting',compact('voting'));
    }

}
