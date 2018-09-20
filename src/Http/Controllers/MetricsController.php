<?php

namespace Llaski\NovaServerMetrics\Http\Controllers;

use Illuminate\Routing\Controller;

class MetricsController extends Controller
{
    public function index()
    {
        return [
            'disk_usage' => $this->getDiskUsage(),
            'memory_usage' => $this->getMemoryUsage(),
            'cpu_usage' => $this->getCpuUsage()
        ];
    }

    private function getDiskUsage()
    {
        $sizePrefixes = ['B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB'];
        $base = 1024;

        $totalDiskSpace = disk_total_space('/');
        $freeDiskSpace = disk_free_space('/');
        $usePercentage = round(($freeDiskSpace / $totalDiskSpace) * 100);

        $size = min((int) log($totalDiskSpace, $base), count($sizePrefixes) - 1);

        return [
            'total_space' => round($totalDiskSpace / pow($base, $size)),
            'free_space' => round($freeDiskSpace / pow($base, $size)),
            'use_percentage' => $usePercentage,
            'unit' => $sizePrefixes[$size],
        ];
    }

    private function getMemoryUsage()
    {
        if (!file_exists(__DIR__ . '/meminfo')) {
            return [
                'freeMemory' => null,
                'usedMemory' => null,
                'memoryUnit' => 'MB',
            ];
        }

        $sizePrefixes = ['KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB'];
        $base = 1024;

        foreach (file(__DIR__ . '/meminfo') as $result) {
            $array = explode(':', str_replace(' ', '', $result));
            $value = preg_replace('/kb/i', '', $array[1]);
            if (preg_match('/^MemTotal/', $result)) {
                $totalMemory = str_replace("\n", '', $value); //500044
            } elseif (preg_match('/^MemFree/', $result)) {
                $freeMemory = str_replace("\n", '', $value); //57140
            }
        }

        $usePercentage = round(($freeMemory / $totalMemory) * 100);

        $size = min((int) log($totalMemory, $base), count($sizePrefixes) - 1);

        return [
            'total_memory' => round($totalMemory / pow($base, $size)),
            'free_memory' => round($freeMemory / pow($base, $size)),
            'use_percentage' => $usePercentage,
            'unit' => $sizePrefixes[$size],
        ];
    }

    private function getCpuUsage()
    {
        $load = sys_getloadavg();

        return [
            'use_percentage' => round($load[0])
        ];
    }
}
