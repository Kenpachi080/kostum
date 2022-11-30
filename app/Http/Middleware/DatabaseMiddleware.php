<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DatabaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = request()->header('api_token');
        dd($token);
        if (request()->header('api_token') !== null) {

            $user = User::query()->where('api_token', $token)->first();
            if (isset($user) && $user->role_id == 1 ) {
                Auth::login($user);
                return $next($request);
            }
        }
        return response(['message' => 'Не авторизован'], 403);
    }
}
