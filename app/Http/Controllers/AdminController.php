<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function postinganJson(){
        $data = DB::select("SELECT a.*, b.nama FROM posts a
                            LEFT JOIN users b ON b.nik = a.nik
                            ORDER BY a.id DESC;");

        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
    }

    public function postingan(){

        if (Auth::user()->nik !== 'daniel.it') {
            return view('403');
        }

        $nik = Auth::user()->nik;

        // $post = DB::select("SELECT a.*, b.nama FROM posts a
        //                     LEFT JOIN users b ON b.nik = a.nik
        //                     ORDER BY a.id DESC;");
        
        $post = DB::table('posts as a')
                    ->select('a.*','b.nama')
                    ->leftJoin('users as b','b.nik','=','a.nik')
                    ->orderBy('a.id','desc')
                    ->paginate(3);

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

        return view('admin.postingan',compact('post','notifPost','notifPostLike','notifPostComment','notifBadge','notifCommentLike','notifCommentBalas'));
    }

}
