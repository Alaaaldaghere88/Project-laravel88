<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class ChangeLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
    $locale = $request->header('Accept-Language', config('app.locale'));
    if (!in_array($locale, ['ar', 'en'])) {
        $locale = config('app.locale');
    }
    App::setLocale($locale);
    return $next($request);
    }

}
