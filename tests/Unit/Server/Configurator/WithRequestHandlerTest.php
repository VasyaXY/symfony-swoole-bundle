<?php

declare(strict_types=1);

namespace vasyaxy\Swoole\Tests\Unit\Server\Configurator;

use vasyaxy\Swoole\Server\Configurator\WithRequestHandler;
use vasyaxy\Swoole\Tests\Unit\Server\RequestHandler\RequestHandlerDummy;
use vasyaxy\Swoole\Tests\Unit\Server\SwooleHttpServerMock;
use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 */
class WithRequestHandlerTest extends TestCase
{
    /**
     * @var RequestHandlerDummy
     */
    private $requestHandlerDummy;

    /**
     * @var WithRequestHandler
     */
    private $configurator;

    protected function setUp(): void
    {
        $this->requestHandlerDummy = new RequestHandlerDummy();

        $this->configurator = new WithRequestHandler($this->requestHandlerDummy);
    }

    public function testConfigure(): void
    {
        $serverMock = SwooleHttpServerMock::make();

        $this->configurator->configure($serverMock);

        self::assertTrue($serverMock->registeredEvent);
        self::assertSame(['request', [$this->requestHandlerDummy, 'handle']], $serverMock->registeredEventPair);
    }
}
