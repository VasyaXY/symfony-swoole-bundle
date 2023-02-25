<?php

namespace vasyaxy\Swoole\Server\Configurator;

use vasyaxy\Swoole\Server\LifecycleHandler\ServerManagerStopHandlerInterface;
use Swoole\Http\Server;

final class WithServerManagerStopHandler implements ConfiguratorInterface
{
    public function __construct(private readonly ServerManagerStopHandlerInterface $handler)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function configure(Server $server): void
    {
        $server->on('ManagerStop', [$this->handler, 'handle']);
    }
}
