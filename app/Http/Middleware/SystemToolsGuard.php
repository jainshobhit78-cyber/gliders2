<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Extra gate for the System Tools maintenance area. On top of super-admin auth,
 * it requires an access password that is hardcoded here (stored as a SHA-256 hash,
 * so the plaintext is not committed). There is intentionally no recovery flow — the
 * only way to change it is to replace the hash below.
 *
 * To change the password, run:  php -r "echo hash('sha256','NEW_PASSWORD');"
 * and paste the result into PASSWORD_HASH.
 */
class SystemToolsGuard
{
    /** SHA-256 of the current System Tools access password. */
    public const PASSWORD_HASH = 'dced63445e1717e8a0db0763489283a70ddeb372e67233cd9bd64b77300fdf84';

    /** Session key set once the password has been entered correctly. */
    public const SESSION_KEY = 'system_tools_unlocked';

    public static function isSuperAdmin(): bool
    {
        $user = auth()->guard('admin')->user();

        return $user && ($user->email === 'admin@gliders.com' || $user->hasRole('admin'));
    }

    public static function passwordMatches(?string $input): bool
    {
        return is_string($input)
            && hash_equals(self::PASSWORD_HASH, hash('sha256', $input));
    }

    public function handle(Request $request, Closure $next): Response
    {
        if (!self::isSuperAdmin()) {
            abort(403, 'User does not have the right permissions.');
        }

        if (!session(self::SESSION_KEY)) {
            abort(403, 'System Tools is locked. Enter the access password first.');
        }

        return $next($request);
    }
}
