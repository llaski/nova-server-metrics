<?php

namespace Llaski\NovaServerMetrics\Metrics;

class CpuUsage
{
    public function resolve()
    {
        $load = sys_getloadavg();

        return [
            'use_percentage' => round($load[0]),
        ];
    }
}
