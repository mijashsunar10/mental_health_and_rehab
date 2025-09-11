<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchase;
use App\Enums\UserRole;

class CheckPackageAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // ✅ Only apply to "User" role
        if ($user && $user->role === UserRole::User) {
            $activePurchase = Purchase::where('user_id', $user->id)
                ->where('status', 'active')
                ->where('end_date', '>', now())
                ->first();

            if (!$activePurchase) {
                return redirect()->route('packages.index')
                    ->with('error', 'You need to purchase a package to access the dashboard');
            }
        }

        return $next($request);
    }
}
