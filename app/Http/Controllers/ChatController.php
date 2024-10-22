<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function index(){
        $chat = DB::select("SELECT * FROM message;");
        $data = DB::select("SELECT * FROM users");
        
        return view('chat.index',compact('data','chat'));
    }

    public function chat(){
        $chat = Message::all();

        return response()->json($chat);
    }

    public function sendMessage(Request $request)
    {
        $message = Message::create([
            'id_user' => auth()->id(),
            'to' => $request->input('to'),
            'message' => $request->input('message')
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }

    public function fetchMessages()
    {
        return Message::with('user')->get();
    }
}
