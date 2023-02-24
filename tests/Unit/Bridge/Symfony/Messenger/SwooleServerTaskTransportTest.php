<?php

declare(strict_types=1);

namespace vasyaxy\Swoole\Tests\Unit\Bridge\Symfony\Messenger;

use vasyaxy\Swoole\Bridge\Symfony\Messenger\Exception\ReceiverNotAvailableException;
use vasyaxy\Swoole\Bridge\Symfony\Messenger\SwooleServerTaskReceiver;
use vasyaxy\Swoole\Bridge\Symfony\Messenger\SwooleServerTaskSender;
use vasyaxy\Swoole\Bridge\Symfony\Messenger\SwooleServerTaskTransport;
use vasyaxy\Swoole\Server\Config\Socket;
use vasyaxy\Swoole\Server\Config\Sockets;
use vasyaxy\Swoole\Server\HttpServer;
use vasyaxy\Swoole\Server\HttpServerConfiguration;
use PHPStan\Testing\TestCase;
use Symfony\Component\Messenger\Envelope;

class SwooleServerTaskTransportTest extends TestCase
{
    use \Prophecy\PhpUnit\ProphecyTrait;

    public function testThatItThrowsExceptionOnAck(): void
    {
        $transport = new SwooleServerTaskTransport(new SwooleServerTaskReceiver(), new SwooleServerTaskSender($this->makeHttpServerDummy()));

        $this->expectException(ReceiverNotAvailableException::class);

        $transport->ack(new Envelope($this->prophesize('object')));
    }

    public function testThatItThrowsExceptionOnReject(): void
    {
        $transport = new SwooleServerTaskTransport(new SwooleServerTaskReceiver(), new SwooleServerTaskSender($this->makeHttpServerDummy()));

        $this->expectException(ReceiverNotAvailableException::class);

        $transport->reject(new Envelope($this->prophesize('object')));
    }

    private function makeHttpServerDummy(): HttpServer
    {
        return new HttpServer(new HttpServerConfiguration(new Sockets(new Socket())));
    }
}
