<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasAccount
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! $user->account && ! $request->routeIs('account.create', 'account.store')) {
            return redirect()->route('account.create');
        }

        return $next($request);
    }
}
