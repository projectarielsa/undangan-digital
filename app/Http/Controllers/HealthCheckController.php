<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;

class HealthCheckController extends Controller
{
    /**
     * Basic health check - returns 200 if app is running.
     * Use this for load balancer health checks.
     */
    public function ping(): JsonResponse
    {
        return response()->json([
            'status' => 'ok',
            'timestamp' => now()->toIso8601String(),
        ]);
    }

    /**
     * Comprehensive health check - checks all critical services.
     * Use this for monitoring dashboards (e.g., Uptime Robot, Pingdom).
     */
    public function status(): JsonResponse
    {
        $checks = [
            'database' => $this->checkDatabase(),
            'cache' => $this->checkCache(),
            'storage' => $this->checkStorage(),
            'queue' => $this->checkQueue(),
        ];

        $allHealthy = collect($checks)->every(fn ($check) => $check['healthy']);

        return response()->json([
            'status' => $allHealthy ? 'healthy' : 'degraded',
            'timestamp' => now()->toIso8601String(),
            'app' => [
                'name' => config('app.name'),
                'environment' => config('app.env'),
                'debug' => config('app.debug'),
                'php_version' => PHP_VERSION,
                'laravel_version' => app()->version(),
            ],
            'checks' => $checks,
        ], $allHealthy ? 200 : 503);
    }

    /**
     * Check database connectivity.
     */
    protected function checkDatabase(): array
    {
        try {
            $start = microtime(true);
            DB::connection()->getPdo();
            DB::select('SELECT 1');
            $latency = round((microtime(true) - $start) * 1000, 2);

            return [
                'healthy' => true,
                'message' => 'Database connection successful',
                'latency_ms' => $latency,
                'driver' => config('database.default'),
            ];
        } catch (\Exception $e) {
            return [
                'healthy' => false,
                'message' => 'Database connection failed',
                'error' => config('app.debug') ? $e->getMessage() : 'Connection error',
            ];
        }
    }

    /**
     * Check cache connectivity.
     */
    protected function checkCache(): array
    {
        try {
            $key = 'health_check_' . uniqid();
            $value = 'test_value';

            $start = microtime(true);
            Cache::put($key, $value, 10);
            $retrieved = Cache::get($key);
            Cache::forget($key);
            $latency = round((microtime(true) - $start) * 1000, 2);

            if ($retrieved !== $value) {
                return [
                    'healthy' => false,
                    'message' => 'Cache read/write mismatch',
                ];
            }

            return [
                'healthy' => true,
                'message' => 'Cache is working',
                'latency_ms' => $latency,
                'driver' => config('cache.default'),
            ];
        } catch (\Exception $e) {
            return [
                'healthy' => false,
                'message' => 'Cache check failed',
                'error' => config('app.debug') ? $e->getMessage() : 'Cache error',
            ];
        }
    }

    /**
     * Check storage accessibility.
     */
    protected function checkStorage(): array
    {
        try {
            $disk = Storage::disk('public');
            $testFile = 'health_check_' . uniqid() . '.txt';

            $start = microtime(true);
            $disk->put($testFile, 'health check');
            $exists = $disk->exists($testFile);
            $disk->delete($testFile);
            $latency = round((microtime(true) - $start) * 1000, 2);

            return [
                'healthy' => $exists,
                'message' => $exists ? 'Storage is accessible' : 'Storage write failed',
                'latency_ms' => $latency,
                'disk' => 'public',
            ];
        } catch (\Exception $e) {
            return [
                'healthy' => false,
                'message' => 'Storage check failed',
                'error' => config('app.debug') ? $e->getMessage() : 'Storage error',
            ];
        }
    }

    /**
     * Check queue connectivity.
     */
    protected function checkQueue(): array
    {
        try {
            $connection = config('queue.default');

            // For database queue, check if jobs table exists
            if ($connection === 'database') {
                $start = microtime(true);
                DB::table('jobs')->count();
                $latency = round((microtime(true) - $start) * 1000, 2);

                return [
                    'healthy' => true,
                    'message' => 'Queue is accessible',
                    'latency_ms' => $latency,
                    'driver' => $connection,
                ];
            }

            // For sync driver, always healthy
            if ($connection === 'sync') {
                return [
                    'healthy' => true,
                    'message' => 'Using sync driver (no queue)',
                    'driver' => $connection,
                ];
            }

            return [
                'healthy' => true,
                'message' => 'Queue configured',
                'driver' => $connection,
            ];
        } catch (\Exception $e) {
            return [
                'healthy' => false,
                'message' => 'Queue check failed',
                'error' => config('app.debug') ? $e->getMessage() : 'Queue error',
            ];
        }
    }
}
