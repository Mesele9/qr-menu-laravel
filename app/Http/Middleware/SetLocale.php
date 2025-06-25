<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache; 
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     * This middleware sets the application locale based on a priority system:
     * 1. Check for a user's explicit choice stored in the session.
     * 2. If not present, check for a system-wide default language set by the admin (from cache/database).
     * 3. If neither is present, Laravel's default fallback_locale from config/app.php will be used.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = null;

        // Priority 1: Check for a locale choice in the user's session.
        if (session()->has('locale')) {
            $locale = session('locale');
        } 
        // Priority 2: If no session locale, get the system-wide default from settings.
        else {
            // We cache this database query forever to avoid hitting the DB on every request.
            // The cache is automatically cleared in SettingsController when settings are saved.
            $locale = Cache::rememberForever('settings.default_language', function () {
                // Use the null-safe operator (?->) to prevent errors if the setting doesn't exist yet.
                return Setting::where('key', 'default_language')->first()?->value;
            });
        }

        // If we found a valid locale from either the session or the cached default, set it.
        if ($locale) {
            App::setLocale($locale);
        }

        // Continue processing the request. If $locale was null, Laravel will use its default fallback.
        return $next($request);
    }
}