<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PollAnswer;

class AnalisisController extends Controller
{
    public function chart() {
        $data = User::selectRaw('gender, COUNT(*) as count')
                    ->groupBy('gender')
                    ->pluck('count', 'gender');
                    
        return view('information', compact('data'));
    }

    public function fetchDataJawaban() {

        $data = DB::select("SELECT jawaban, SUM(value) AS vote FROM poll_answers GROUP BY jawaban ORDER BY jawaban ASC");
        $user = DB::select("SELECT COUNT(*) AS total_users, gender FROM users GROUP BY gender;");
    
        $output = [];
        foreach($data as $row){
            $output[] = array(
                'jawaban' => $row->jawaban,
                'vote' => (float)$row->vote
            );
        }

        $output2 = [['gender','total_users']];
        foreach($user as $item){
            $output2[] = [
                $item->gender,
                (int)$item->total_users
            ];
        }
        
        return response()->json([
            'chart1' => $output,
            'chart2' => $output2,
        ]);
    }
    
}
