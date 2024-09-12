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
    public function index(Request $request){

        $user = Auth::user()->nik;

        $post = DB::select("SELECT p.*, u.nama, u.foto FROM posts p
                        LEFT JOIN users u ON u.nik = p.nik
                        ORDER BY p.id DESC;");
                        
        $komen = DB::select("SELECT c.*, u.nama, u.foto FROM comments c
                        LEFT JOIN users u ON u.nik = c.nik
                        ORDER BY c.id DESC;");

        $poll = DB::select("SELECT pl.*, pa.jawaban, pa.poll_id, p.judul, p.id, pa.id, pa.value, a.nik AS voted, a.created_at AS time_vote FROM polls pl
								 LEFT JOIN poll_answers pa ON pa.poll_id = pl.id
								 LEFT JOIN posts p ON p.id = pl.id_post
                                 LEFT JOIN answer_vote a ON a.jawaban = pa.jawaban
                                 AND a.nik = ?
                                 ORDER BY pa.id ASC",[$user]);

        $pollCollection = collect($poll);
        $groupedPoll = $pollCollection->groupBy('id_post');

        return view('welcome',compact('post','komen','groupedPoll'));
    }
}
