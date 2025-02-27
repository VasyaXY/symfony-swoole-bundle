<?php

namespace vasyaxy\Swoole\Server\Api;

use vasyaxy\Swoole\Client\Http;
use vasyaxy\Swoole\Client\HttpClient;

final class ApiServerClient implements ApiServerInterface
{
    public function __construct(private readonly HttpClient $client)
    {
    }

    /**
     * Get Swoole HTTP Server status.
     */
    public function status(): array
    {
        return $this->client->send('/api/server')['response']['body'];
    }

    /**
     * Shutdown Swoole HTTP Server.
     */
    public function shutdown(): void
    {
        $this->client->send('/api/server', Http::METHOD_DELETE);
    }

    /**
     * Reload Swoole HTTP Server workers.
     */
    public function reload(): void
    {
        $this->client->send('/api/server', Http::METHOD_PATCH);
    }

    /**
     * Get Swoole HTTP Server metrics.
     */
    public function metrics(): array
    {
        return $this->client->send('/api/server/metrics')['response']['body'];
    }
}
