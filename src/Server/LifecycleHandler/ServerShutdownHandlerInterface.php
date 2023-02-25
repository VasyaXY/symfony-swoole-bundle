<?php

namespace vasyaxy\Swoole\Server\LifecycleHandler;

use Swoole\Server;

interface ServerShutdownHandlerInterface
{
    /**
     * Handle "OnShutdown" event.
     */
    public function handle(Server $server): void;
}
