<?php

namespace vasyaxy\Swoole\Server\RequestHandler;

use Swoole\Http\Request;
use Swoole\Http\Response;

interface RequestHandlerInterface
{
    /**
     * Handles swoole request and modifies swoole response accordingly.
     */
    public function handle(Request $request, Response $response): void;
}
