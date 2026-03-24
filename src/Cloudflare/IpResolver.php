<?php

namespace WallaceMartinss\FilamentSecurity\Cloudflare;

use Illuminate\Http\Request;

class IpResolver
{
    /**
     * Resolve the real client IP address.
     *
     * Priority: CF-Connecting-IP > X-Real-IP > X-Forwarded-For > REMOTE_ADDR
     */
    public static function resolve(?Request $request = null): string
    {
        $request = $request ?? request();

        // Cloudflare sets this header with the real client IP
        if ($ip = $request->header('CF-Connecting-IP')) {
            return self::sanitize($ip);
        }

        // Nginx proxy sets this
        if ($ip = $request->header('X-Real-IP')) {
            return self::sanitize($ip);
        }

        // Standard forwarded header (first IP is the client)
        if ($forwarded = $request->header('X-Forwarded-For')) {
            $ips = array_map('trim', explode(',', $forwarded));

            return self::sanitize($ips[0]);
        }

        return $request->ip() ?? '0.0.0.0';
    }

    protected static function sanitize(string $ip): string
    {
        $ip = trim($ip);

        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            return $ip;
        }

        return '0.0.0.0';
    }
}
