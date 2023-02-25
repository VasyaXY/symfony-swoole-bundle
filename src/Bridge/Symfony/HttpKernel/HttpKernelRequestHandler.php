<?php

namespace vasyaxy\Swoole\Bridge\Symfony\HttpKernel;

use vasyaxy\Swoole\Bridge\Symfony\HttpFoundation\RequestFactoryInterface;
use vasyaxy\Swoole\Bridge\Symfony\HttpFoundation\ResponseProcessorInjectorInterface;
use vasyaxy\Swoole\Bridge\Symfony\HttpFoundation\ResponseProcessorInterface;
use vasyaxy\Swoole\Server\RequestHandler\RequestHandlerInterface;
use vasyaxy\Swoole\Server\Runtime\BootableInterface;
use Swoole\Http\Request as SwooleRequest;
use Swoole\Http\Response as SwooleResponse;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpKernel\TerminableInterface;

final class HttpKernelRequestHandler implements RequestHandlerInterface, BootableInterface
{
    public function __construct(
        private readonly KernelInterface                    $kernel,
        private readonly RequestFactoryInterface            $requestFactory,
        private readonly ResponseProcessorInjectorInterface $processorInjector,
        private readonly ResponseProcessorInterface         $responseProcessor
    )
    {
    }

    /**
     * {@inheritdoc}
     */
    public function boot(array $runtimeConfiguration = []): void
    {
        $this->kernel->boot();
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function handle(SwooleRequest $request, SwooleResponse $response): void
    {
        $httpFoundationRequest = $this->requestFactory->make($request);
        $this->processorInjector->injectProcessor($httpFoundationRequest, $response);
        $httpFoundationResponse = $this->kernel->handle($httpFoundationRequest);
        $this->responseProcessor->process($httpFoundationResponse, $response);

        if ($this->kernel instanceof TerminableInterface) {
            $this->kernel->terminate($httpFoundationRequest, $httpFoundationResponse);
        }
    }
}
