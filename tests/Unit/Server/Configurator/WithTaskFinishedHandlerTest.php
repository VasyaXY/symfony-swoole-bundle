<?php

declare(strict_types=1);

namespace vasyaxy\Swoole\Tests\Unit\Server\Configurator;

use vasyaxy\Swoole\Server\Configurator\WithTaskFinishedHandler;
use vasyaxy\Swoole\Server\HttpServerConfiguration;
use vasyaxy\Swoole\Server\TaskHandler\NoOpTaskFinishedHandler;
use vasyaxy\Swoole\Tests\Unit\Server\IntMother;
use vasyaxy\Swoole\Tests\Unit\Server\SwooleHttpServerMock;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;

/**
 * @runTestsInSeparateProcesses
 */
class WithTaskFinishedHandlerTest extends TestCase
{
    use \Prophecy\PhpUnit\ProphecyTrait;
    /**
     * @var NoOpTaskFinishedHandler
     */
    private $noOpTaskFinishedHandler;

    /**
     * @var WithTaskFinishedHandler
     */
    private $configurator;

    /**
     * @var HttpServerConfiguration|ObjectProphecy
     */
    private $configurationProphecy;

    protected function setUp(): void
    {
        $this->noOpTaskFinishedHandler = new NoOpTaskFinishedHandler();
        $this->configurationProphecy = $this->prophesize(HttpServerConfiguration::class);

        /** @var HttpServerConfiguration $configurationMock */
        $configurationMock = $this->configurationProphecy->reveal();

        $this->configurator = new WithTaskFinishedHandler($this->noOpTaskFinishedHandler, $configurationMock);
    }

    public function testConfigure(): void
    {
        $this->configurationProphecy->getTaskWorkerCount()
            ->willReturn(IntMother::randomPositive())
            ->shouldBeCalled()
        ;

        $swooleServerOnEventSpy = SwooleHttpServerMock::make();

        $this->configurator->configure($swooleServerOnEventSpy);

        self::assertTrue($swooleServerOnEventSpy->registeredEvent);
        self::assertSame(['finish', [$this->noOpTaskFinishedHandler, 'handle']], $swooleServerOnEventSpy->registeredEventPair);
    }

    public function testDoNotConfigureWhenNoTaskWorkers(): void
    {
        $this->configurationProphecy->getTaskWorkerCount()
            ->willReturn(0)
            ->shouldBeCalled()
        ;

        $swooleServerOnEventSpy = SwooleHttpServerMock::make();

        $this->configurator->configure($swooleServerOnEventSpy);

        self::assertFalse($swooleServerOnEventSpy->registeredEvent);
    }
}
