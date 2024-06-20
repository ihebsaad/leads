<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class LogUserActions
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (Auth::check()) {
            activity()
                ->causedBy(Auth::user())
                ->withProperties(['attributes' => $request->all()])
        ->log('Connexion '/*.$request->route()->getName()*/);
        }

        return $response;
    }
}

