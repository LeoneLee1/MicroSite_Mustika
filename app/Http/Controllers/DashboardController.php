<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request){
        $post = DB::select("SELECT p.*, u.nama, u.foto FROM posts p
                        LEFT JOIN users u ON u.nik = p.nik
                        ORDER BY p.id DESC;");

        $komen = DB::select("SELECT c.*, u.nama, u.foto FROM comments c
                        LEFT JOIN users u ON u.nik = c.nik
                        ORDER BY c.id DESC;");

        return view('welcome',compact('post','komen'));
    }
}
