<?php

namespace vasyaxy\Swoole\Server\RequestHandler;

use vasyaxy\Swoole\Server\RequestHandler\ExceptionHandler\ExceptionHandlerInterface;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Throwable;

final class ExceptionRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly RequestHandlerInterface   $decorated,
        private readonly ExceptionHandlerInterface $exceptionHandler
    )
    {
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request, Response $response): void
    {
        try {
            $this->decorated->handle($request, $response);
        } catch (Throwable $exception) {
            $this->exceptionHandler->handle($request, $exception, $response);
        }
    }
}
