<?php

namespace vasyaxy\Swoole\Bridge\Symfony\Messenger;

use Assert\Assertion;
use vasyaxy\Swoole\Server\TaskHandler\TaskHandlerInterface;
use Swoole\Server;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

final class SwooleServerTaskTransportHandler implements TaskHandlerInterface
{
    public function __construct(
        private readonly MessageBusInterface $bus,
        private readonly ?TaskHandlerInterface $decorated = null)
    {
    }

    public function handle(Server $server, int $taskId, int $fromId, $data): void
    {
        Assertion::isInstanceOf($data, Envelope::class);
        /* @var $data Envelope */

        $this->bus->dispatch($data);

        if ($this->decorated instanceof TaskHandlerInterface) {
            $this->decorated->handle($server, $taskId, $fromId, $data);
        }
    }
}
