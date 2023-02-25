<?php

namespace vasyaxy\Swoole\Server\Configurator;

use vasyaxy\Swoole\Server\WorkerHandler\WorkerStartHandlerInterface;
use Swoole\Http\Server;

final class WithWorkerStartHandler implements ConfiguratorInterface
{
    public function __construct(private readonly WorkerStartHandlerInterface $handler)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function configure(Server $server): void
    {
        $server->on('WorkerStart', [$this->handler, 'handle']);
    }
}
