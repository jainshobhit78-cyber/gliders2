<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

final class SystemStatus
{
    /**
     * Build a live status snapshot for the current request.
     *
     * @return array{
     *     client_ip: string,
     *     secure: bool,
     *     connection_label: string,
     *     tls_protocol: string,
     *     database_online: bool,
     *     uptime_seconds: int|null,
     *     uptime_label: string,
     *     healthy: bool
     * }
     */
    public function snapshot(Request $request): array
    {
        $secure = $request->isSecure();
        $databaseOnline = $this->databaseIsOnline();
        $uptimeSeconds = $this->serverUptimeSeconds();

        return [
            'client_ip' => $request->ip() ?? 'Unavailable',
            'secure' => $secure,
            'connection_label' => $secure ? 'Encrypted' : 'Unencrypted',
            'tls_protocol' => $secure ? ($request->server('SSL_PROTOCOL') ?: 'HTTPS') : 'None',
            'database_online' => $databaseOnline,
            'uptime_seconds' => $uptimeSeconds,
            'uptime_label' => self::formatUptime($uptimeSeconds),
            'healthy' => $secure && $databaseOnline,
        ];
    }

    public static function formatUptime(?int $seconds): string
    {
        if ($seconds === null || $seconds < 0) {
            return 'Unavailable';
        }

        $days = intdiv($seconds, 86400);
        $hours = intdiv($seconds % 86400, 3600);
        $minutes = intdiv($seconds % 3600, 60);

        return sprintf('%02dD : %02dH : %02dM', $days, $hours, $minutes);
    }

    private function databaseIsOnline(): bool
    {
        try {
            DB::connection()->select('SELECT 1');

            return true;
        } catch (Throwable) {
            return false;
        }
    }

    private function serverUptimeSeconds(): ?int
    {
        $uptimeFile = '/proc/uptime';

        if (! is_readable($uptimeFile)) {
            return null;
        }

        $contents = @file_get_contents($uptimeFile);
        if ($contents === false || ! preg_match('/^([0-9]+(?:\.[0-9]+)?)/', trim($contents), $matches)) {
            return null;
        }

        return (int) floor((float) $matches[1]);
    }
}
