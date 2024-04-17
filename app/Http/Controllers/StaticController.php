<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class StaticController extends Controller
{

    public function history()
    {
        return view('static.history');
    }

    public function leaderboard()
    {
        return view('static.leaderboard');
    }

    public function faq()
    {
        return view('static.faq');
    }

    public function contact()
    {
        return view('static.contact');
    }
}
