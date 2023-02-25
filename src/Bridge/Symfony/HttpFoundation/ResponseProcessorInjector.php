<?php

namespace vasyaxy\Swoole\Bridge\Symfony\HttpFoundation;

use Swoole\Http\Response as SwooleResponse;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

final class ResponseProcessorInjector implements ResponseProcessorInjectorInterface
{
    public function __construct(private readonly ResponseProcessorInterface $responseProcessor)
    {
    }

    public function injectProcessor(
        HttpFoundationRequest $request,
        SwooleResponse        $swooleResponse
    ): void
    {
        $request->attributes->set(
            self::ATTR_KEY_RESPONSE_PROCESSOR,
            function (HttpFoundationResponse $httpFoundationResponse) use ($swooleResponse): void {
                $this->responseProcessor->process($httpFoundationResponse, $swooleResponse);
            }
        );
    }
}
