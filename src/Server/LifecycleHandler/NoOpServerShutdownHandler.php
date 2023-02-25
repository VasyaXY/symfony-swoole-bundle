<?php

namespace vasyaxy\Swoole\Server\LifecycleHandler;

use Swoole\Server;

final class NoOpServerShutdownHandler implements ServerShutdownHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function handle(Server $server): void
    {
        // noop
    }
}
