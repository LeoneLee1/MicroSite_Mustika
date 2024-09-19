<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\AnswerVote;
use App\Models\PollAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){

        $user = Auth::user()->nik;

        $post = DB::select("SELECT p.*, u.nama, u.unit,u.gender , p.created_at AS time_post FROM posts p
                        LEFT JOIN users u ON u.nik = p.nik
                        ORDER BY p.id DESC;");
                        
        $komen = DB::select("SELECT c.*, u.nama FROM comments c
                        LEFT JOIN users u ON u.nik = c.nik
                        ORDER BY c.id DESC;");

        $poll = DB::select("SELECT pl.* FROM polls pl;");

        $jawaban = DB::select("SELECT a.*, an.nik AS voted , a.value FROM poll_answers a
                                LEFT JOIN polls p ON p.id = a.poll_id
                                LEFT JOIN answer_vote an ON an.jawaban = a.jawaban
                                AND an.nik = '$user'
                                ORDER BY a.id ASC;");

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

        return view('welcome',compact('post','komen','poll','jawaban','jawabanModal'));
    }
}
