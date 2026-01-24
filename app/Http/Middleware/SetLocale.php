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
        $locale = $request->query('lang') 
            ?? Session::get('locale') 
            ?? config('app.locale', 'mk');

        if (!in_array($locale, $this->supportedLocales)) {
            $locale = config('app.locale', 'mk');
        }

        App::setLocale($locale);
        Session::put('locale', $locale);

        return $next($request);
    }
}
