<?php

namespace vasyaxy\Swoole\Server\Runtime\HMR;

use Swoole\Server;

interface HotModuleReloaderInterface
{
    /**
     * Reload HttpServer if changes in files were detected.
     */
    public function tick(Server $server): void;
}
