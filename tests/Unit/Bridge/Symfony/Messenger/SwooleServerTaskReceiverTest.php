<?php

declare(strict_types=1);

namespace vasyaxy\Swoole\Tests\Unit\Bridge\Symfony\Messenger;

use vasyaxy\Swoole\Bridge\Symfony\Messenger\Exception\ReceiverNotAvailableException;
use vasyaxy\Swoole\Bridge\Symfony\Messenger\SwooleServerTaskReceiver;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;

class SwooleServerTaskReceiverTest extends TestCase
{
    use \Prophecy\PhpUnit\ProphecyTrait;

    public function testThatItThrowsExceptionOnGet(): void
    {
        $receiver = new SwooleServerTaskReceiver();

        $this->expectException(ReceiverNotAvailableException::class);

        $receiver->get();
    }

    public function testThatItThrowsExceptionOnReject(): void
    {
        $receiver = new SwooleServerTaskReceiver();

        $this->expectException(ReceiverNotAvailableException::class);

        $receiver->reject(new Envelope($this->prophesize('object')->reveal()));
    }

    public function testThatItThrowsExceptionOnAck(): void
    {
        $receiver = new SwooleServerTaskReceiver();

        $this->expectException(ReceiverNotAvailableException::class);

        $receiver->ack(new Envelope($this->prophesize('object')->reveal()));
    }
}
