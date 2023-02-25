<?php

namespace vasyaxy\Swoole\Server\Configurator;

use vasyaxy\Swoole\Server\HttpServerConfiguration;
use vasyaxy\Swoole\Server\TaskHandler\TaskFinishedHandlerInterface;
use Swoole\Http\Server;

final class WithTaskFinishedHandler implements ConfiguratorInterface
{
    public function __construct(
        private readonly TaskFinishedHandlerInterface $handler,
        private readonly HttpServerConfiguration      $configuration
    )
    {
    }

    /**
     * {@inheritdoc}
     */
    public function configure(Server $server): void
    {
        if ($this->configuration->getTaskWorkerCount() > 0) {
            $server->on('finish', [$this->handler, 'handle']);
        }
    }
}
