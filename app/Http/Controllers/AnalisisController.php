<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PollAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AnalisisController extends Controller
{
    public function chart() {

        $user = Auth::user();
        $nik = $user->nik;

        $total_post = DB::select("SELECT COUNT(*) AS total FROM posts
                                WHERE nik = '$nik';");

        $total_postingan = DB::select("SELECT COUNT(*) AS total_post from posts;");

        $total_voting = DB::select("SELECT COUNT(*) AS total_vote from answer_vote;");

        $lastest_post_like = DB::select("SELECT p.*, u.foto, CASE WHEN u.role = 'Anonymous' THEN 'NoName' WHEN u.role = 'admin' THEN 'INSAN MUSTIKA' ELSE u.nama END AS nama FROM posts p
                                    LEFT JOIN users u ON u.nik = p.nik
                                    ORDER BY p.like DESC, p.id DESC
                                    LIMIT 4;");
                                    
        $lastest_post_comment = DB::select("SELECT p.*, u.foto, CASE WHEN u.role = 'Anonymous' THEN 'NoName' WHEN u.role = 'admin' THEN 'INSAN MUSTIKA' ELSE u.nama END AS nama FROM posts p
                                    LEFT JOIN users u ON u.nik = p.nik
                                    ORDER BY p.komen DESC, p.id DESC
                                    LIMIT 4;");

        $lastest_post_voting = DB::select("SELECT p.*, u.foto, CASE WHEN u.role = 'Anonymous' THEN 'NoName' WHEN u.role = 'admin' THEN 'INSAN MUSTIKA' ELSE u.nama END AS nama, pl.voting FROM posts p
                                            LEFT JOIN users u ON u.nik = p.nik
                                            LEFT JOIN polls pl ON pl.id_post = p.id
                                            ORDER BY pl.voting DESC, p.id DESC
                                            LIMIT 4;");

        $comment = DB::select("SELECT COUNT(*) AS total_comment, id_post FROM comments
                                GROUP BY id_post;");

        $total_like = DB::select("SELECT COUNT(*) AS total_like FROM post_like");
        $total_comment = DB::select("SELECT COUNT(*) AS total_komen FROM comments");

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

        return view('analysis',compact('total_post','total_postingan','total_voting','lastest_post_like','comment','total_like','total_comment','lastest_post_comment','lastest_post_voting','notifPost','notifPostLike'));
    }
    
}
