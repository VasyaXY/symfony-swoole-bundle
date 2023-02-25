<?php

namespace vasyaxy\Swoole\Bridge\Upscale\Blackfire;

use vasyaxy\Swoole\Server\Configurator\ConfiguratorInterface;
use Swoole\Http\Server;
use Upscale\Swoole\Blackfire\Profiler;

final class WithProfiler implements ConfiguratorInterface
{
    public function __construct(private readonly Profiler $profiler)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function configure(Server $server): void
    {
        $this->profiler->instrument($server);
    }
}
