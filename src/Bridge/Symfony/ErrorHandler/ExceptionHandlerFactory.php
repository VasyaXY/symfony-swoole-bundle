<?php

namespace vasyaxy\Swoole\Bridge\Symfony\ErrorHandler;

use Error;
use ErrorException;
use ReflectionMethod;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Throwable;

final class ExceptionHandlerFactory
{
    /**
     * @var bool
     */
    private bool $isSymfony4 = false;

    public function __construct(private readonly HttpKernelInterface $kernel, private readonly ReflectionMethod $throwableHandler)
    {

        if ('handleException' === $throwableHandler->getName()) {
            $this->isSymfony4 = true;
        }
    }

    public function newExceptionHandler(Request $request): callable
    {
        return function (Throwable $e) use ($request) {
            if ($this->isSymfony4 && $e instanceof Error) {
                $e = new ErrorException(
                    $e->getMessage(),
                    $e->getCode(),
                    \E_ERROR,
                    $e->getFile(),
                    $e->getLine(),
                    $e->getPrevious()
                );
            }

            return $this->throwableHandler->invoke($this->kernel, $e, $request, HttpKernelInterface::MASTER_REQUEST);
        };
    }
}
