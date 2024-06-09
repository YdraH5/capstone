<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
{
    if (auth()->check() && ! $request->session()->has('lastActivityTime')) {
        $request->session()->put('lastActivityTime', time());
    }

    $lastActivity = $request->session()->get('lastActivityTime');

    if (auth()->check() && (time() - $lastActivity) > config('session.lifetime') * 60) {
        auth()->logout();
        $request->session()->forget('lastActivityTime');
        return redirect()->route('login')->with('message', 'Session expired. Please log in again.');
    }

    $request->session()->put('lastActivityTime', time());

    return $next($request);
    }
}
