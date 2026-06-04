<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSeller
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->cookie('zizini_demo_role') === 'seller') {
            return $next($request);
        }

        if ($request->cookie('zizini_demo_role') === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login')->with('status', 'Please log in as a seller to continue.');
        }

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('status', 'You are logged in as admin. Use the admin workspace or log out first.');
        }

        if (! in_array($user->role, ['Seller', 'Reseller', 'Verified Seller', 'Farm/Dealer'], true)) {
            abort(403);
        }

        return $next($request);
    }
}
