<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class PlayerController extends Controller
{
    /**
     * Handle the "play" action.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function play()
    {
        if (Cookie::has('username')) {
            return redirect()->route('levels.index');
        }

        return redirect()->route('pseudo.form');
    }

    public function showPseudoForm()
    {
        return view('pseudo_form');
    }

    public function storePseudo(Request $request)
    {
        $pseudo = $request->input('username');

        $cookie = Cookie::make('username', $pseudo, 43200);

        return redirect()->route('levels.index')->cookie($cookie);
    }
}
