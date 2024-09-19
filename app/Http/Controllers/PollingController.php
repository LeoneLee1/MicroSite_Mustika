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
        $user = Auth::user()->nik;
        // $post = DB::select("SELECT * FROM posts
        //                         WHERE nik = '$user'
        //                         ORDER BY id DESC
        //                         LIMIT 1");

        $post = DB::table('posts')
                    ->where('nik', $user)
                    ->orderBy('id','desc')
                    ->first();
        // dd($post);
        if($post){
            $post_id = $post->id;
        } else {
            $post_id = null;
        }
        
        return view('polling.create',compact('post_id'));
    }

    public function insert(Request $request)
    {
        // $request->validate([
        //     'id_post' => 'required',
        //     'soal' => 'required|string|max:255',
        //     'jawaban' => 'required|array|min:1',
        //     'jawaban.*' => 'required|string|max:255',
        // ]);
        
        // $poll = new Poll();
        // $poll->id_post = $request->id_post;
        // $poll->nik = $request->nik;
        // $poll->soal = $request->soal;

        // if ($poll->save()) {
        //     foreach ($request->jawaban as $jawaban) {
        //         $pollAnswer = new PollAnswer();
        //         $pollAnswer->poll_id = $poll->id;
        //         $pollAnswer->jawaban = $jawaban;
        //         $pollAnswer->save();

        //     }
        //     Alert::success('Berhasil!', 'Membuat Polling.');
        //     return redirect('/');
        // } else {
        //     Alert::error('Gagal!', 'Membuat Polling.');
        //     return back();
        // }


        // Validasi input
        $request->validate([
            'id_post' => 'required',
            'soal' => 'required|array|min:1',
            'soal.*' => 'required|string|max:255',
            'jawaban' => 'required|array|min:1',
            'jawaban.*' => 'required|array|min:1',
            'jawaban.*.*' => 'required|string|max:255', 
        ]);

        foreach ($request->soal as $key => $soal) {
            $poll = new Poll();
            $poll->id_post = $request->id_post;
            $poll->nik = $request->nik;
            $poll->soal = $soal;

            if ($poll->save()) {
                foreach ($request->jawaban[$key] as $jawaban) {
                    $pollAnswer = new PollAnswer();
                    $pollAnswer->poll_id = $poll->id;
                    $pollAnswer->id_post = $poll->id_post;
                    $pollAnswer->jawaban = $jawaban;
                    $pollAnswer->save();
                }
            } else {
                Alert::error('Gagal!', 'Membuat Polling.');
                return back();
            }
        }

        Alert::success('Berhasil!', 'Membuat Polling.');
        return redirect('/'); 
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
