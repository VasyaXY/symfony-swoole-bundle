<?php

namespace vasyaxy\Swoole\Server\Api;

use vasyaxy\Swoole\Server\Config\Sockets;
use vasyaxy\Swoole\Server\Configurator\ConfiguratorInterface;
use vasyaxy\Swoole\Server\RequestHandler\RequestHandlerInterface;
use Swoole\Http\Server;

/**
 * @internal This class will be dropped, once named server listeners will be implemented
 */
final class WithApiServerConfiguration implements ConfiguratorInterface
{
    public function __construct(
        private readonly Sockets                 $sockets,
        private readonly RequestHandlerInterface $requestHandler
    )
    {
    }

    public function configure(Server $server): void
    {
        if (!$this->sockets->hasApiSocket()) {
            return;
        }

        $apiSocketPort = $this->sockets->getApiSocket()->port();
        foreach ($server->ports as $port) {
            if ($port->port === $apiSocketPort) {
                $port->on('request', [$this->requestHandler, 'handle']);

                return;
            }
        }
    }
}
