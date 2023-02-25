<?php

namespace vasyaxy\Swoole\Server\Configurator;

use vasyaxy\Swoole\Server\LifecycleHandler\ServerShutdownHandlerInterface;
use Swoole\Http\Server;

final class WithServerShutdownHandler implements ConfiguratorInterface
{
    public function __construct(private readonly ServerShutdownHandlerInterface $handler)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function configure(Server $server): void
    {
        $server->on('shutdown', [$this->handler, 'handle']);
    }
}
