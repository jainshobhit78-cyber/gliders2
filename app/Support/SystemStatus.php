<?php

namespace App\Support;

use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
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
     *     deployed_at_iso: string,
     *     deployed_at_label: string,
     *     deployed_at_title: string,
     *     healthy: bool
     * }
     */
    public function snapshot(Request $request): array
    {
        $secure = $request->isSecure();
        $databaseOnline = $this->databaseIsOnline();
        $deployment = $this->deploymentDetails();

        return [
            'client_ip' => $request->ip() ?? 'Unavailable',
            'secure' => $secure,
            'connection_label' => $secure ? 'Encrypted' : 'Unencrypted',
            'tls_protocol' => $secure ? ($request->server('SSL_PROTOCOL') ?: 'HTTPS') : 'None',
            'database_online' => $databaseOnline,
            'deployed_at_iso' => $deployment['iso'],
            'deployed_at_label' => $deployment['label'],
            'deployed_at_title' => $deployment['title'],
            'healthy' => $secure && $databaseOnline,
        ];
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

    /**
     * Persist the time at which the current Git revision is first served.
     *
     * @return array{iso: string, label: string, title: string}
     */
    private function deploymentDetails(): array
    {
        [$fingerprint, $fallbackTimestamp] = $this->deploymentFingerprint();
        $statePath = storage_path('framework/deployment-status.json');
        $state = $this->readDeploymentState($statePath);

        if (($state['fingerprint'] ?? null) !== $fingerprint || empty($state['deployed_at'])) {
            $deployedAt = CarbonImmutable::now('UTC');
            $newState = json_encode([
                'fingerprint' => $fingerprint,
                'deployed_at' => $deployedAt->toIso8601String(),
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

            $written = $newState !== false
                && @file_put_contents($statePath, $newState, LOCK_EX) !== false;

            if (! $written) {
                $deployedAt = CarbonImmutable::createFromTimestamp($fallbackTimestamp, 'UTC');
            }
        } else {
            try {
                $deployedAt = CarbonImmutable::parse($state['deployed_at'], 'UTC');
            } catch (Throwable) {
                $deployedAt = CarbonImmutable::now('UTC');
            }
        }

        $indiaTime = $deployedAt->setTimezone('Asia/Kolkata');

        return [
            'iso' => $indiaTime->toIso8601String(),
            'label' => strtoupper($indiaTime->format('d M H:i')),
            'title' => $indiaTime->format('d M Y, h:i:s A').' IST',
        ];
    }

    /**
     * @return array{fingerprint: string, deployed_at: string}|array{}
     */
    private function readDeploymentState(string $statePath): array
    {
        if (! is_readable($statePath)) {
            return [];
        }

        $state = json_decode((string) @file_get_contents($statePath), true);

        return is_array($state) ? $state : [];
    }

    /**
     * @return array{string, int}
     */
    private function deploymentFingerprint(): array
    {
        $revision = $this->gitRevision();
        if ($revision !== null) {
            return ['git:'.$revision, time()];
        }

        $latestTimestamp = 0;
        $latestFile = '';
        $roots = [
            app_path(),
            config_path(),
            database_path('migrations'),
            resource_path('views'),
            base_path('routes'),
        ];

        foreach ($roots as $root) {
            if (! is_dir($root)) {
                continue;
            }

            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS)
            );

            foreach ($files as $file) {
                if ($file->isFile() && $file->getMTime() >= $latestTimestamp) {
                    $latestTimestamp = $file->getMTime();
                    $latestFile = $file->getPathname();
                }
            }
        }

        $latestTimestamp = $latestTimestamp ?: time();

        return [hash('sha256', $latestFile.'|'.$latestTimestamp), $latestTimestamp];
    }

    private function gitRevision(): ?string
    {
        $gitDirectory = base_path('.git');

        if (is_file($gitDirectory)) {
            $pointer = trim((string) @file_get_contents($gitDirectory));
            if (str_starts_with($pointer, 'gitdir:')) {
                $gitDirectory = trim(substr($pointer, 7));
                if (! str_starts_with($gitDirectory, '/') && ! preg_match('/^[A-Za-z]:[\\\\\/]/', $gitDirectory)) {
                    $gitDirectory = base_path($gitDirectory);
                }
            }
        }

        $headPath = $gitDirectory.DIRECTORY_SEPARATOR.'HEAD';
        if (! is_readable($headPath)) {
            return null;
        }

        $head = trim((string) @file_get_contents($headPath));
        if (preg_match('/^[a-f0-9]{40}$/i', $head)) {
            return strtolower($head);
        }

        if (! str_starts_with($head, 'ref: ')) {
            return null;
        }

        $reference = substr($head, 5);
        $referencePath = $gitDirectory.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $reference);
        if (is_readable($referencePath)) {
            $revision = trim((string) @file_get_contents($referencePath));

            return preg_match('/^[a-f0-9]{40}$/i', $revision) ? strtolower($revision) : null;
        }

        $packedReferences = $gitDirectory.DIRECTORY_SEPARATOR.'packed-refs';
        if (is_readable($packedReferences)) {
            foreach (file($packedReferences, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
                if ($line[0] === '#' || $line[0] === '^') {
                    continue;
                }

                [$revision, $name] = array_pad(explode(' ', $line, 2), 2, null);
                if ($name === $reference && preg_match('/^[a-f0-9]{40}$/i', $revision)) {
                    return strtolower($revision);
                }
            }
        }

        return null;
    }
}
