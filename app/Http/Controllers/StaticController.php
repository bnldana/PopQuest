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

    public function privacy()
    {
        return view('static.privacy');
    }

    public function cookies()
    {
        return view('static.cookies');
    }

    public function terms()
    {
        return view('static.terms');
    }

    public function legal()
    {
        return view('static.legal');
    }
}
