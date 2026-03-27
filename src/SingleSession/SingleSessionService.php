<?php

namespace WallaceMartinss\FilamentSecurity\SingleSession;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use WallaceMartinss\FilamentSecurity\EventLog\Enums\SecurityEventType;
use WallaceMartinss\FilamentSecurity\EventLog\Models\SecurityEvent;

class SingleSessionService
{
    /**
     * Flag to prevent the Logout event from clearing tracking
     * when the middleware forces a logout.
     */
    public static bool $isForcedLogout = false;

    /**
     * Handle a successful login: invalidate all other sessions for this user.
     */
    public static function handleLogin(Authenticatable $user): void
    {
        $currentSessionId = session()->getId();
        $userId = $user->getAuthIdentifier();

        // Check if there are other sessions to destroy (for event logging)
        $hadOtherSessions = static::hasOtherSessions($userId, $currentSessionId);

        static::destroyOtherSessions($userId, $currentSessionId);

        if ($hadOtherSessions) {
            SecurityEvent::record(SecurityEventType::SessionTerminated->value, [
                'metadata' => [
                    'user_id' => $userId,
                    'new_session' => $currentSessionId,
                ],
            ]);
        }

        // Flag for middleware to update tracking after session regeneration
        session()->put('filament-security:activate-session', true);
    }

    /**
     * Check if the user has other active sessions.
     */
    protected static function hasOtherSessions(int|string $userId, string $exceptSessionId): bool
    {
        $driver = config('session.driver');

        if ($driver === 'database') {
            try {
                return DB::table(config('session.table', 'sessions'))
                    ->where('user_id', $userId)
                    ->where('id', '!=', $exceptSessionId)
                    ->exists();
            } catch (\Throwable) {
                return false;
            }
        }

        // For other drivers: check if there's a tracked session different from current
        $previousSessionId = Cache::get(static::cacheKey($userId));

        return $previousSessionId !== null && $previousSessionId !== $exceptSessionId;
    }

    /**
     * Destroy all other sessions for the given user.
     *
     * - Database driver: bulk delete by user_id (efficient single query)
     * - Redis/File/other: destroy the previously tracked session by ID
     */
    protected static function destroyOtherSessions(int|string $userId, string $exceptSessionId): void
    {
        $driver = config('session.driver');

        if ($driver === 'database') {
            static::destroyDatabaseSessions($userId, $exceptSessionId);
        }

        // For all drivers: also destroy the previously tracked session
        static::destroyTrackedSession($userId, $exceptSessionId);
    }

    /**
     * Delete all session rows for the user except the current one.
     */
    protected static function destroyDatabaseSessions(int|string $userId, string $exceptSessionId): void
    {
        try {
            DB::table(config('session.table', 'sessions'))
                ->where('user_id', $userId)
                ->where('id', '!=', $exceptSessionId)
                ->delete();
        } catch (\Throwable $e) {
            Log::warning('Filament Security: Failed to invalidate database sessions', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Destroy the previously tracked session via the session handler.
     * Works with any session driver (Redis, file, etc.).
     */
    protected static function destroyTrackedSession(int|string $userId, string $currentSessionId): void
    {
        $previousSessionId = Cache::get(static::cacheKey($userId));

        if ($previousSessionId && $previousSessionId !== $currentSessionId) {
            try {
                session()->getHandler()->destroy($previousSessionId);
            } catch (\Throwable $e) {
                Log::warning('Filament Security: Failed to destroy previous session', [
                    'user_id' => $userId,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    /**
     * Clear the active session tracking for a user.
     */
    public static function clearTracking(int|string $userId): void
    {
        Cache::forget(static::cacheKey($userId));
    }

    /**
     * Get the cache key for tracking a user's active session.
     */
    public static function cacheKey(int|string $userId): string
    {
        return "filament-security:active-session:{$userId}";
    }
}
