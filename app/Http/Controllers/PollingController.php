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

        // Create a new Poll instance
        $poll = new Poll();
        $poll->id_post = $request->id_post;
        $poll->soal = $request->soal;

        // Save the poll (question)
        if ($poll->save()) {
            // Save each answer associated with the poll
            foreach ($request->jawaban as $jawaban) {
                $pollAnswer = new PollAnswer();
                $pollAnswer->poll_id = $poll->id; // Associate with the poll
                $pollAnswer->jawaban = $jawaban;
                $pollAnswer->save();
            }

            // Success alert and redirection
            Alert::success('Berhasil!', 'Membuat Polling.');
            return redirect('/');
        } else {
            // Error alert and return back
            Alert::error('Gagal!', 'Membuat Polling.');
            return back();
        }
    }
}
