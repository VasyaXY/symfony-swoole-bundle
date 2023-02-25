<?php

namespace vasyaxy\Swoole\Server\Configurator;

use vasyaxy\Swoole\Server\HttpServerConfiguration;
use vasyaxy\Swoole\Server\TaskHandler\TaskHandlerInterface;
use Swoole\Http\Server;

final class WithTaskHandler implements ConfiguratorInterface
{
    public function __construct(
        private readonly TaskHandlerInterface    $handler,
        private readonly HttpServerConfiguration $configuration
    )
    {
    }

    /**
     * {@inheritdoc}
     */
    public function configure(Server $server): void
    {
        if ($this->configuration->getTaskWorkerCount() > 0) {
            $server->on('task', [$this->handler, 'handle']);
        }
    }
}
