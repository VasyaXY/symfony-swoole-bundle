<?php

declare(strict_types=1);

namespace vasyaxy\Swoole\Tests\Unit\Server\Configurator;

use vasyaxy\Swoole\Server\Configurator\WithServerManagerStopHandler;
use vasyaxy\Swoole\Server\LifecycleHandler\NoOpServerManagerStopHandler;
use vasyaxy\Swoole\Tests\Unit\Server\SwooleHttpServerMock;
use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 */
class WithServerManagerStopHandlerTest extends TestCase
{
    /**
     * @var NoOpServerManagerStopHandler
     */
    private $noOpServerManagerStopHandler;

    /**
     * @var WithServerManagerStopHandler
     */
    private $configurator;

    protected function setUp(): void
    {
        $this->noOpServerManagerStopHandler = new NoOpServerManagerStopHandler();

        $this->configurator = new WithServerManagerStopHandler($this->noOpServerManagerStopHandler);
    }

    public function testConfigure(): void
    {
        $swooleServerOnEventSpy = SwooleHttpServerMock::make();

        $this->configurator->configure($swooleServerOnEventSpy);

        self::assertTrue($swooleServerOnEventSpy->registeredEvent);
        self::assertSame(['ManagerStop', [$this->noOpServerManagerStopHandler, 'handle']], $swooleServerOnEventSpy->registeredEventPair);
    }
}
