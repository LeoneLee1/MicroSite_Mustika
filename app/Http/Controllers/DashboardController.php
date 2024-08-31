<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $post = DB::select("SELECT p.*, u.nama, u.foto FROM posts p
                        LEFT JOIN users u ON u.nik = p.nik
                        ORDER BY p.id DESC;");

        $komen = DB::select("SELECT c.*, u.nama, u.foto FROM comments c
                        LEFT JOIN users u ON u.nik = c.nik
                        ORDER BY c.id DESC;");

        return view('welcome',compact('post','komen'));
    }

    public function komen(){
        $komen = DB::select("SELECT c.*, u.nama, p.id FROM comments c
                            LEFT JOIN users u ON u.nik = p.nik
                            LEFT JOIN posts p ON p.id = c.id_post
                            WHERE c.id_post = p.id");
    }
}
