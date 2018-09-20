<?php

namespace Llaski\NovaServerMetrics\Http\Controllers;

use Illuminate\Routing\Controller;
use Llaski\NovaServerMetrics\Metrics\DiskSpace;
use Llaski\NovaServerMetrics\Metrics\MemoryUsage;
use Llaski\NovaServerMetrics\Metrics\CpuUsage;

class MetricsController extends Controller
{
    public function index()
    {
        return [
            'disk_space' => (new DiskSpace)->resolve(),
            'memory_usage' => (new MemoryUsage)->resolve(),
            'cpu_usage' => (new CPUUsage)->resolve()
        ];
    }

}
