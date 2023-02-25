<?php

namespace vasyaxy\Swoole\Server\Configurator;

use vasyaxy\Swoole\Server\LifecycleHandler\ServerManagerStartHandlerInterface;
use Swoole\Http\Server;

final class WithServerManagerStartHandler implements ConfiguratorInterface
{
    public function __construct(private readonly ServerManagerStartHandlerInterface $handler)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function configure(Server $server): void
    {
        $server->on('ManagerStart', [$this->handler, 'handle']);
    }
}
