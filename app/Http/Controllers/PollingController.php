<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\PollAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        
        $poll = new Poll();
        $poll->id_post = $request->id_post;
        $poll->soal = $request->soal;

        if ($poll->save()) {
            foreach ($request->jawaban as $jawaban) {
                $pollAnswer = new PollAnswer();
                $pollAnswer->poll_id = $poll->id;
                $pollAnswer->jawaban = $jawaban;
                $pollAnswer->save();
            }
            Alert::success('Berhasil!', 'Membuat Polling.');
            return redirect('/');
        } else {
            Alert::error('Gagal!', 'Membuat Polling.');
            return back();
        }
    }
}
