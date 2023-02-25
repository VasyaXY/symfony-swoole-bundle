<?php

namespace vasyaxy\Swoole\Server\Configurator;

use Swoole\Http\Server;

interface ConfiguratorInterface
{
    public function configure(Server $server): void;
}
