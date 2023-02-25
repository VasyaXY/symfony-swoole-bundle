<?php

declare(strict_types=1);

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
    private $sockets;
    private $requestHandler;

    public function __construct(Sockets $sockets, RequestHandlerInterface $requestHandler)
    {
        $this->sockets = $sockets;
        $this->requestHandler = $requestHandler;
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
