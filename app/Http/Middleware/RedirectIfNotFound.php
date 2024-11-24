<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfNotFound
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if ($response->status() === 404) {
            return redirect('/'); // Redirect to a custom 404 page
        }
        return $response;
    }
}
