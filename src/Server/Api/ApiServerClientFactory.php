<?php

namespace vasyaxy\Swoole\Server\Api;

use Assert\Assertion;
use vasyaxy\Swoole\Client\HttpClient;
use vasyaxy\Swoole\Server\Config\Sockets;

final class ApiServerClientFactory
{
    public function __construct(private readonly Sockets $sockets)
    {
    }

    public function newClient(array $options = []): ApiServerClient
    {
        Assertion::true($this->sockets->hasApiSocket(), 'Swoole HTTP Server is not configured properly. To access API trough HTTP interface, you must enable and provide proper address of configured API Server.');

        return new ApiServerClient(HttpClient::fromSocket(
            $this->sockets->getApiSocket(),
            $options
        ));
    }
}
