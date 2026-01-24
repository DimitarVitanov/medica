<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    protected array $supportedLocales = ['mk', 'en'];

    public function handle(Request $request, Closure $next)
    {
        // Check for explicit language change via query param
        if ($request->has('lang')) {
            $locale = $request->query('lang');
        } else {
            // Use session locale if set, otherwise default to Macedonian
            $locale = Session::get('locale', 'mk');
        }

        if (!in_array($locale, $this->supportedLocales)) {
            $locale = 'mk';
        }

        App::setLocale($locale);
        Session::put('locale', $locale);

        return $next($request);
    }
}
