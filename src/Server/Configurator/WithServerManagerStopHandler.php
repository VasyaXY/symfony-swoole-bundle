<?php

declare(strict_types=1);

namespace vasyaxy\Swoole\Server\Configurator;

use vasyaxy\Swoole\Server\LifecycleHandler\ServerManagerStopHandlerInterface;
use Swoole\Http\Server;

final class WithServerManagerStopHandler implements ConfiguratorInterface
{
    private $handler;

    public function __construct(ServerManagerStopHandlerInterface $handler)
    {
        $this->handler = $handler;
    }

    /**
     * {@inheritdoc}
     */
    public function configure(Server $server): void
    {
        $server->on('ManagerStop', [$this->handler, 'handle']);
    }
}
