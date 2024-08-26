<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App; // Import the App facade
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $locale = 'fr')
    {
        App::setLocale($locale);

        return $next($request);
    }
}