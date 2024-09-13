<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\Post;
use App\Models\AnswerVote;
use App\Models\PollAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PollingController extends Controller
{
    public function create(){
        // $post_id = DB::select("SELECT * FROM posts
        //                     ORDER BY id DESC
        //                     LIMIT 1");

        $post = DB::table('posts')
                    ->orderBy('id','desc')
                    ->first();

        if($post){
            $post_id = $post->id;
        } else {
            $post_id = null;
        }
        
        return view('polling.create',compact('post_id'));
    }

    public function insert(Request $request)
    {
        $request->validate([
            'id_post' => 'required',
            'soal' => 'required|string|max:255',
            'jawaban' => 'required|array|min:1',
            'jawaban.*' => 'required|string|max:255',
        ]);

        $nikUser = DB::select("SELECT nik FROM users");
        
        $poll = new Poll();
        $poll->id_post = $request->id_post;
        $poll->soal = $request->soal;

        if ($poll->save()) {
            foreach ($request->jawaban as $jawaban) {
                $pollAnswer = new PollAnswer();
                $pollAnswer->poll_id = $poll->id;
                $pollAnswer->jawaban = $jawaban;
                $pollAnswer->save();

                // DB::insert("INSERT INTO answer_vote (id_answer, jawaban, nik) 
                //             SELECT a.id AS id_answer, a.jawaban , b.nik  FROM poll_answers a JOIN users b
                //             WHERE a.jawaban = '$jawaban'");

            }
            Alert::success('Berhasil!', 'Membuat Polling.');
            return redirect('/');
        } else {
            Alert::error('Gagal!', 'Membuat Polling.');
            return back();
        }
    }

    public function vote($answerId, Request $request){

        $userNik = Auth::user()->nik;

        $pollAnswer = PollAnswer::find($answerId);

        if (!$pollAnswer) {
            return response()->json(['success' => false, 'message' => 'Answer not found'], 404);
        }

        $existingVote = AnswerVote::where('nik', $userNik)
                                    ->where('poll_id', $pollAnswer->poll_id)
                                    ->first();

        if ($existingVote) {
            if ($existingVote->id_jawaban == $answerId) {
                $existingVote->delete();

                $pollAnswer->value -= 1;
                $pollAnswer->save();

                return response()->json(['success' => true, 'message' => 'Vote removed']);
            } else {

                $oldAnswer = PollAnswer::find($existingVote->id_jawaban);
                if ($oldAnswer) {
                    $oldAnswer->value -= 1;
                    $oldAnswer->save();
                }
                
                $existingVote->id_jawaban = $answerId;
                $existingVote->jawaban = $pollAnswer->jawaban;
                $existingVote->save();

                $pollAnswer->value += 1;
                $pollAnswer->save();

                return response()->json(['success' => true, 'message' => 'Vote updated']);

                // return response()->json(['success' => false, 'message' => 'You have already voted in this poll'], 403);
            }
        } else {
            AnswerVote::create([
                'nik' => $userNik,
                'id_jawaban' => $answerId,
                'jawaban' => $pollAnswer->jawaban,
                'poll_id' => $pollAnswer->poll_id,
            ]);

            $pollAnswer->value += 1;
            $pollAnswer->save();

            return response()->json(['success' => true, 'message' => 'Vote added']);
        }


        // $existingVote = AnswerVote::where('nik',$userNik)
        //                             ->where('id_jawaban',$answerId)
        //                             ->first();

        // if ($existingVote) {
        //     $existingVote->delete();

        //     $jawabanValue = PollAnswer::find($answerId);
        //     if ($jawabanValue) {
        //         $jawabanValue->value -= 1;
        //         $jawabanValue->save();
        //     }
        // } else {
        //     $pollAnswer = PollAnswer::find($answerId);

        //     if ($pollAnswer) {
        //         AnswerVote::create([
        //             'nik' => $userNik,
        //             'id_jawaban' => $answerId,
        //             'jawaban' => $pollAnswer->jawaban,
        //             'poll_id' => $pollAnswer->poll_id,
        //         ]);
        //     }

        //     $jawabanValue = PollAnswer::find($answerId);
        //     if ($jawabanValue) {
        //         $jawabanValue->value += 1;
        //         $jawabanValue->save();
        //     }
        // }

        // return response()->json(['success' => true]);
    }

    public function viewVotes($poll_id){

        $votes = DB::select("SELECT p.soal, pa.jawaban, GROUP_CONCAT(a.nik ORDER BY a.created_at ASC SEPARATOR ', ') AS votes, COUNT(a.nik) AS total_votes, 
                                GROUP_CONCAT(DATE_FORMAT(a.created_at, '%d/%m/%Y %H:%i') ORDER BY a.created_at ASC SEPARATOR ', ') AS time_votes
                                FROM poll_answers pa
                                LEFT JOIN answer_vote a ON a.jawaban = pa.jawaban
                                AND a.poll_id = pa.poll_id
                                LEFT JOIN polls p ON p.id = pa.poll_id
                                WHERE pa.poll_id = ?
                                GROUP BY pa.jawaban, p.soal
                                ORDER BY pa.jawaban;", [$poll_id]);

        $votesCollection = collect($votes);

        return view('polling.votes',compact('votesCollection'));
    }

}
