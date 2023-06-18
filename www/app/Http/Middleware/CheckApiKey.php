<?php

namespace App\Http\Middleware;

use Closure;

class CheckApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $apiKey = $_GET['apikey'] ?? '';
        if ($apiKey !== $_ENV['SERVER_API_KEY'] ?? '') {
            return response(trans('backpack::base.unauthorized'), 401);
        }

        return $next($request);
    }
}
