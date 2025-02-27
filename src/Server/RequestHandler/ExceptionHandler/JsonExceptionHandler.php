<?php

namespace vasyaxy\Swoole\Server\RequestHandler\ExceptionHandler;

use vasyaxy\Swoole\Client\Http;
use vasyaxy\Swoole\Component\ExceptionArrayTransformer;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Throwable;

final class JsonExceptionHandler implements ExceptionHandlerInterface
{
    public function __construct(
        private readonly ExceptionArrayTransformer $exceptionArrayTransformer,
        private readonly string                    $verbosity = 'default'
    )
    {
    }

    public function handle(Request $request, Throwable $exception, Response $response): void
    {
        $data = $this->exceptionArrayTransformer->transform($exception, $this->verbosity);

        $response->header(Http::HEADER_CONTENT_TYPE, Http::CONTENT_TYPE_APPLICATION_JSON);
        $response->status(500);
        $response->end(\json_encode($data, \JSON_THROW_ON_ERROR));
    }
}
