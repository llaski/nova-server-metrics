<?php

namespace Llaski\NovaServerMetrics\Metrics;

class MemoryUsage
{
    public function resolve()
    {
        if (!file_exists('/proc/meminfo')) {
            return null;
        }

        $sizePrefixes = ['KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB'];
        $base = 1024;

        foreach (file('/proc/meminfo') as $result) {
            $array = explode(':', str_replace(' ', '', $result));
            $value = preg_replace('/kb/i', '', $array[1]);
            if (preg_match('/^MemTotal/', $result)) {
                $totalMemory = str_replace("\n", '', $value); //500044
            } elseif (preg_match('/^MemFree/', $result)) {
                $freeMemory = str_replace("\n", '', $value); //57140
            }
        }

        $usedMemory = $totalMemory - $freeMemory;
        $usePercentage = round(($usedMemory / $totalMemory) * 100);

        $size = min((int) log($totalMemory, $base), count($sizePrefixes) - 1);

        return [
            'total_memory' => round($totalMemory / pow($base, $size)),
            'used_memory' => round($usedMemory / pow($base, $size)),
            'use_percentage' => $usePercentage,
            'unit' => $sizePrefixes[$size],
        ];
    }
}
