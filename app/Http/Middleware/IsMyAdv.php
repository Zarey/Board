<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Advertisement;

class IsMyAdv
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        // Админу можно всё...
        if (Auth::id() == 1) {
            return $next($request);
        }
        // $request->myadv - id объявления
        
        // Если речь о работе с объявлением по его id, проверяется авторство || наличие как такового
        if ($request->myadv) {
            $advertisement = Advertisement::find($request->myadv);
            if (($advertisement && $advertisement->author_id != Auth::id()) || !$advertisement) {
                return abort(404);
            }
            // Здесь авторство считается подтвержденным
            elseif ($advertisement && Auth::id()) {
                return $next($request);
            }
        }
        // В остальных случаях просто проверяется залогинен ли пользователь
        elseif (Auth::id()) {
            return $next($request);
        } else {
            return abort(404);
        }
    }
}
