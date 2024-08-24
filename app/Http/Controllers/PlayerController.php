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
        // Vérifie si le cookie 'username' existe
        if (Cookie::has('username')) {
            // Redirige directement vers la page des niveaux si le cookie existe
            return redirect()->route('levels.index');
        }

        // Sinon, redirige vers la page pour entrer le pseudo
        return redirect()->route('pseudo.form');
    }

    public function showPseudoForm()
    {
        return view('pseudo_form'); // Remplacez 'pseudo_form' par le nom de votre vue pour entrer le pseudo
    }

    public function storePseudo(Request $request)
    {
        $pseudo = $request->input('username');

        // Crée un cookie pour stocker le pseudo pour 30 jours
        $cookie = Cookie::make('username', $pseudo, 43200); // 43200 minutes = 30 jours

        // Redirige vers la page des niveaux avec le cookie
        return redirect()->route('levels.index')->cookie($cookie);
    }
}
