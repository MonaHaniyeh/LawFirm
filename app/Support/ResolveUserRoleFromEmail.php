<?php

namespace App\Support;

/**
 * Resolves a user's role purely from their email address, per the rules in
 * config/roles.php. No role dropdown on the sign-up form — the system
 * decides based on who owns that inbox.
 *
 * Resolution order (first match wins):
 *   1. Explicit admin allow-list       → 'admin'
 *   2. Explicit accountant allow-list  → 'accountant'
 *   3. Email domain == staff domain    → 'lawyer'
 *   4. Anything else                   → 'client'  (config('roles.default_role'))
 */
class ResolveUserRoleFromEmail
{
    public static function resolve(string $email): string
    {
        $email = strtolower(trim($email));
        $domain = self::domainOf($email);

        if (in_array($email, self::normalize(config('roles.admins', [])), true)) {
            return 'admin';
        }

        if (in_array($email, self::normalize(config('roles.accountants', [])), true)) {
            return 'accountant';
        }

        if ($domain !== null && $domain === strtolower(config('roles.staff_domain'))) {
            return 'lawyer';
        }

        return config('roles.default_role', 'client');
    }

    private static function domainOf(string $email): ?string
    {
        $parts = explode('@', $email);

        return count($parts) === 2 ? strtolower($parts[1]) : null;
    }

    private static function normalize(array $emails): array
    {
        return array_map(fn ($e) => strtolower(trim($e)), $emails);
    }
}