<?php

declare(strict_types=1);

namespace vasyaxy\Swoole\Bridge\Upscale\Blackfire;

use vasyaxy\Swoole\Server\Configurator\ConfiguratorInterface;
use Swoole\Http\Server;
use Upscale\Swoole\Blackfire\Profiler;

final class WithProfiler implements ConfiguratorInterface
{
    /**
     * @var Profiler
     */
    private $profiler;

    public function __construct(Profiler $profiler)
    {
        $this->profiler = $profiler;
    }

    /**
     * {@inheritdoc}
     */
    public function configure(Server $server): void
    {
        $this->profiler->instrument($server);
    }
}
