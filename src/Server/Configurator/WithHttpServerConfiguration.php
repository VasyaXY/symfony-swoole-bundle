<?php

namespace vasyaxy\Swoole\Server\Configurator;

use vasyaxy\Swoole\Server\HttpServerConfiguration;
use Swoole\Http\Server;

final class WithHttpServerConfiguration implements ConfiguratorInterface
{
    public function __construct(private readonly HttpServerConfiguration $configuration)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function configure(Server $server): void
    {
        $server->set($this->configuration->getSwooleSettings());

        $defaultSocket = $this->configuration->getServerSocket();
        if (0 === $defaultSocket->port()) {
            $this->configuration->changeServerSocket($defaultSocket->withPort($server->port));
        }
    }
}
