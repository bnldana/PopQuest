<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function searchMovie(Request $request)
    {
        $query = $request->input('query');
        if (!$query) {
            return response()->json(['error' => 'Query not provided'], 400);
        }

        $apiKey = env('TMDB_API_KEY');
        $response = Http::get("https://api.themoviedb.org/3/search/movie", [
            'api_key' => $apiKey,
            'query' => $query,
            'language' => 'fr-FR'
        ]);

        if ($response->successful()) {
            return $response->json()['results'];
        } else {
            return response()->json(['error' => 'TMDB API request failed'], 500);
        }
    }
}
