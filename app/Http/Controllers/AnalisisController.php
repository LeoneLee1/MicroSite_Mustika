<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PollAnswer;

class AnalisisController extends Controller
{
    public function chart() {  
        return view('information');
    }
    
}
