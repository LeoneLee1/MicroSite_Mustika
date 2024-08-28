<?php

namespace App\Http\Controllers;

use App\Models\Poll;
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

    public function insert(Request $request){
        $request->validate([
            'id_post' => 'required',
            'soal' => 'required',
            'jawaban' => 'required',
            'jawaban.*' => 'required',
        ]);

        $poll = new Poll();
        $poll->id_post = $request->id_post;
        $poll->soal = $request->soal;
        $poll->jawaban = json_encode($request->jawaban);
        
        if ($poll->save()) {
            Alert::success('Berhasil!','Membuat Polling.');
            return redirect('/');
        } else {
            Alert::error('Gagal!','Membuat Polling.');
            return back();
        }

    }
}
