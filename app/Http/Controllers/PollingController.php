<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\Post;
use App\Models\AnswerVote;
use App\Models\PollAnswer;
use Illuminate\Http\Request;
use App\Models\NotifPostVote;
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
        
        return view('polling.create',compact('post_id','notifPost','notifPostLike','notifPostComment','notifBadge','notifCommentLike','notifCommentBalas'));
    }

    public function insert(Request $request){
        $request->validate([
            'id_post' => 'required',
            'soal' => 'required|array|min:1',
            'soal.*' => 'required',
            'jawaban' => 'required|array|min:1',
            'jawaban.*' => 'required|array|min:1',
            'jawaban.*.*' => 'required', 
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
        return redirect('/beranda'); 
    }

    // public function vote($answerId, Request $request){

    //     $userNik = Auth::user()->nik;

    //     $pollAnswer = PollAnswer::find($answerId);

    //     $poll = Poll::findOrFail($pollAnswer->poll_id);

    //     if (!$pollAnswer) {
    //         return response()->json(['success' => false, 'message' => 'Answer not found'], 404);
    //     }

    //     $existingVote = AnswerVote::where('nik', $userNik)
    //                                 ->where('poll_id', $pollAnswer->poll_id)
    //                                 ->first();

    //     if ($existingVote) {
    //         if ($existingVote->id_jawaban == $answerId) {
    //             // $existingVote->delete();

    //             // $pollAnswer->value -= 1;
    //             // $pollAnswer->save();

    //             // $poll->voting -= 1;
    //             // $poll->save();

    //             return response()->json(['success' => true, 'message' => 'Sudah Vote']);
    //         } else {
    //             $oldAnswer = PollAnswer::find($existingVote->id_jawaban);
    //             if ($oldAnswer) {
    //                 // $oldAnswer->value -= 1;
    //                 // $oldAnswer->save();
    //             }
                
    //             // $existingVote->id_jawaban = $answerId;
    //             // $existingVote->jawaban = $pollAnswer->jawaban;
    //             // $existingVote->save();

    //             // $pollAnswer->value += 1;
    //             // $pollAnswer->save();

    //             return response()->json(['success' => true, 'message' => 'Sudah Vote']);

    //             // return response()->json(['success' => false, 'message' => 'You have already voted in this poll'], 403);
    //         }
    //     } else {
    //         AnswerVote::create([
    //             'nik' => $userNik,
    //             'id_jawaban' => $answerId,
    //             'jawaban' => $pollAnswer->jawaban,
    //             'poll_id' => $pollAnswer->poll_id,
    //             'id_post' => $pollAnswer->id_post,
    //         ]);

    //         $pollAnswer->value += 1;
    //         $pollAnswer->save();

    //         $poll->voting += 1;
    //         $poll->save();

    //         // $notifVote = new NotifPostVote();
    //         // $notifVote->id_post = $pollAnswer->id_post;
    //         // $notifVote->id_vote = $answerId;
    //         // $notifVote->nik = $userNik;
    //         // $notifVote->save();

    //         return response()->json(['success' => true, 'message' => 'Vote added']);
    //     }
    // }

    public function deleteVote($id){
        $answer_vote = AnswerVote::findOrFail($id);

        $id_poll = $answer_vote->poll_id;
        $id_jawaban = $answer_vote->id_jawaban;

        $poll = Poll::where('id',$id_poll)->first();
        $poll_answer = PollAnswer::where('id',$id_jawaban)->first();

        if ($answer_vote->delete()) {
            $poll->voting -= 1;
            $poll->save();

            $poll_answer->value -= 1;
            $poll_answer->save();

            $notifVote = NotifPostVote::where('id_post',$answer_vote->id_post)
                                    ->where('id_vote',$id_jawaban)
                                    ->where('nik',$answer_vote->nik)
                                    ->delete();

            Alert::success('berhasil bro hehehehe');
            return back();
        } else {
            Alert::error('gagal bro hehehehe');
            return back();
        }
        
    }

}
