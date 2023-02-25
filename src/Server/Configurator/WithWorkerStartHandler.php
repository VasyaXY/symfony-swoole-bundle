<?php

declare(strict_types=1);

namespace vasyaxy\Swoole\Server\Configurator;

use vasyaxy\Swoole\Server\WorkerHandler\WorkerStartHandlerInterface;
use Swoole\Http\Server;

final class WithWorkerStartHandler implements ConfiguratorInterface
{
    private $handler;

    public function __construct(WorkerStartHandlerInterface $handler)
    {
        $this->handler = $handler;
    }

    /**
     * {@inheritdoc}
     */
    public function configure(Server $server): void
    {
        $server->on('WorkerStart', [$this->handler, 'handle']);
    }
}
