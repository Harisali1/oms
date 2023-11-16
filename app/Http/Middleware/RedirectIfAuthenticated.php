<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        switch ($guard) {
            case 'admin':
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('dashboard.index');
                }
                break;
            case 'web':
                if (Auth::guard($guard)->check()) {
                    $joey = auth()->user();
                    if ($joey->is_active == 0) {
                        return redirect()->route('signup-success-get');
                    }
                    else {
                        return redirect()->route('profile');
                    }
                }
                break;
            default:

                if (Auth::guard($guard)->check()) {
                    return redirect()->route('index');
                }
                break;

        }

        return $next($request);
    }
}
