<?php

namespace vasyaxy\Swoole\Server\Configurator;

use vasyaxy\Swoole\Server\RequestHandler\RequestHandlerInterface;
use Swoole\Http\Server;

final class WithRequestHandler implements ConfiguratorInterface
{
    public function __construct(private readonly RequestHandlerInterface $requestHandler)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function configure(Server $server): void
    {
        $server->on('request', [$this->requestHandler, 'handle']);
    }
}
