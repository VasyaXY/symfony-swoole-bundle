<?php

declare(strict_types=1);

namespace vasyaxy\Swoole\Tests\Fixtures\Symfony\TestBundle\ExceptionHandler;

use vasyaxy\Swoole\Client\Http;
use vasyaxy\Swoole\Server\RequestHandler\ExceptionHandler\ExceptionHandlerInterface;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Throwable;

final class TestCustomExceptionHandler implements ExceptionHandlerInterface
{
    public function handle(Request $request, Throwable $exception, Response $response): void
    {
        $response->header(Http::HEADER_CONTENT_TYPE, Http::CONTENT_TYPE_TEXT_PLAIN);
        $response->status(500);
        $response->end('Very custom exception handler');
    }
}
