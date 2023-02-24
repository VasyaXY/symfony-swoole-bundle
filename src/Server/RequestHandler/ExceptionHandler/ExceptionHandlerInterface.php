<?php

declare(strict_types=1);

namespace vasyaxy\Swoole\Server\RequestHandler\ExceptionHandler;

use Swoole\Http\Request;
use Swoole\Http\Response;
use Throwable;

interface ExceptionHandlerInterface
{
    public function handle(Request $request, Throwable $exception, Response $response): void;
}
