<?php

namespace vasyaxy\Swoole\Server\LifecycleHandler;

use Swoole\Server;

final class NoOpServerManagerStopHandler implements ServerManagerStopHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function handle(Server $server): void
    {
        // noop
    }
}
