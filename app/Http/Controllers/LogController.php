<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public function logHistory(Request $request){

        $user = Auth::user()->nik;

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

        $currentDate = Carbon::now()->subDays(7)->toDateString();

        $role = Auth::user()->role;

        if ($role === 'Admin') {
            $dataLogs = DB::select("SELECT a.*, b.nama FROM logs a
                                    LEFT JOIN users b ON b.nik = a.nik
                                    WHERE a.tanggal >= '$currentDate'
                                    ORDER BY a.tanggal DESC,a.created_at DESC;");
        } else {
            $dataLogs = DB::select("SELECT a.*, b.nama FROM logs a
                                    LEFT JOIN users b ON b.nik = a.nik
                                    WHERE a.tanggal >= '$currentDate' AND a.nik = '$user'
                                    ORDER BY a.tanggal DESC,a.created_at DESC;");
        }
        
        $logsByTanggal = collect($dataLogs)->groupBy('tanggal');
        

        return view('logHistory',compact('notifPost','notifPostLike','notifPostComment','notifBadge','notifCommentLike','notifCommentBalas','logsByTanggal'));
    }
}
