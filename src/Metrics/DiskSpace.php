<?php

namespace Llaski\NovaServerMetrics\Metrics;

class DiskSpace
{
    public function resolve()
    {
        $sizePrefixes = ['B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB'];
        $base = 1024;

        $totalDiskSpace = disk_total_space('/');
        $freeDiskSpace = disk_free_space('/');
        $usedDiskSpace = $totalDiskSpace - $freeDiskSpace;
        $usePercentage = round(($usedDiskSpace / $totalDiskSpace) * 100);

        $size = min((int) log($totalDiskSpace, $base), count($sizePrefixes) - 1);

        return [
            'total_space' => round($totalDiskSpace / pow($base, $size)),
            'used_space' => round($usedDiskSpace / pow($base, $size)),
            'use_percentage' => $usePercentage,
            'unit' => $sizePrefixes[$size],
        ];
    }
}
