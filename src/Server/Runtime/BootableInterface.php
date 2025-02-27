<?php

namespace vasyaxy\Swoole\Server\Runtime;

interface BootableInterface
{
    /**
     * Used to provide or override configuration at runtime.
     *
     * This method will be called directly before starting Swoole server.
     */
    public function boot(array $runtimeConfiguration = []): void;
}
