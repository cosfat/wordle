<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class ActivityByUser
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $expiresAt = Carbon::now()->addMinutes(1); // keep online for 1 min
            Cache::put('user-is-online-' . Auth::id(), true, $expiresAt);
// last seen
            User::where('id', Auth::id())->update(['last_seen' => (new \DateTime())->format("Y-m-d H:i:s")]);
        }
        return $next($request);
    }
}
