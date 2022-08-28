<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $locale_prefix = $request->route('locale');
        $available_locales = config('app.available_locales');
        if (in_array($locale_prefix, $available_locales)) {
            app()->setLocale($locale_prefix);
            \Carbon\Carbon::setLocale($locale_prefix);
        } else {
            app()->setLocale(config('app.locale'));
            \Carbon\Carbon::setLocale(config('app.locale'));
        }
        return $next($request);
    }
}
