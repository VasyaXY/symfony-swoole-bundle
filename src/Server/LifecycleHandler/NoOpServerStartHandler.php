<?php

namespace vasyaxy\Swoole\Server\LifecycleHandler;

use Swoole\Server;

final class NoOpServerStartHandler implements ServerStartHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function handle(Server $server): void
    {
        // noop
    }
}
