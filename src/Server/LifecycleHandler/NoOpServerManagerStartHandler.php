<?php

namespace vasyaxy\Swoole\Server\LifecycleHandler;

use Swoole\Server;

final class NoOpServerManagerStartHandler implements ServerManagerStartHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function handle(Server $server): void
    {
        // noop
    }
}
