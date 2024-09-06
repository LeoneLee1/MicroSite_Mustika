<?php

namespace App\Http\Controllers;

use App\Models\AnswerVote;
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

        $poll = DB::select("SELECT pl.*, pa.jawaban, pa.poll_id, p.judul, p.id, pa.id, pa.value FROM polls pl
								 LEFT JOIN poll_answers pa ON pa.poll_id = pl.id
								 LEFT JOIN posts p ON p.id = pl.id_post;");

        $answers = DB::select("SELECT id FROM poll_answers");
        $answerIds = array_column($answers, 'id');

        $votesCount = AnswerVote::whereIn('jawaban', $answerIds)->count();

        // dd($votesCount);

        $pollCollection = collect($poll);

        $groupedPoll = $pollCollection->groupBy('id_post');

        return view('welcome',compact('post','komen','groupedPoll','votesCount'));
    }
}
