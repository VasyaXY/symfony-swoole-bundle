<?php

namespace vasyaxy\Swoole\Server\LifecycleHandler;

use Swoole\Server;

interface ServerStartHandlerInterface
{
    /**
     * Handle "OnStart" event.
     */
    public function handle(Server $server): void;
}
