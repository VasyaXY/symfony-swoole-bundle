<?php

declare(strict_types=1);

namespace vasyaxy\Swoole\Tests\Unit\Server\Configurator;

use vasyaxy\Swoole\Server\Configurator\ConfiguratorInterface;
use Swoole\Http\Server;

final class ConfiguratorDummy implements ConfiguratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function configure(Server $server): void
    {
        // noop
    }
}
