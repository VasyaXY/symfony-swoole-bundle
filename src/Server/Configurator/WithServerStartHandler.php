<?php

namespace vasyaxy\Swoole\Server\Configurator;

use vasyaxy\Swoole\Server\HttpServerConfiguration;
use vasyaxy\Swoole\Server\LifecycleHandler\ServerStartHandlerInterface;
use Swoole\Http\Server;

final class WithServerStartHandler implements ConfiguratorInterface
{
    public function __construct(
        private readonly ServerStartHandlerInterface $handler,
        private readonly HttpServerConfiguration     $configuration
    )
    {
    }

    /**
     * {@inheritdoc}
     */
    public function configure(Server $server): void
    {
        // see: https://github.com/swoole/swoole-src/blob/077c2dfe84d9f2c6d47a4e105f41423421dd4c43/src/server/reactor_process.cc#L181
        if ($this->configuration->isReactorRunningMode()) {
            return;
        }

        $server->on('start', [$this->handler, 'handle']);
    }
}
