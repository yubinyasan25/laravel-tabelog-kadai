<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PaidUser
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->is_paid) {
            return redirect()->route('top')->with('error', '有料会員限定機能です。');
        }

        return $next($request);
    }
}
