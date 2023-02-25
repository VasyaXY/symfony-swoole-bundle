<?php

namespace vasyaxy\Swoole\Bridge\Symfony\Messenger;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\TransportInterface;

final class SwooleServerTaskTransport implements TransportInterface
{
    public function __construct(
        private readonly SwooleServerTaskReceiver $receiver,
        private readonly SwooleServerTaskSender   $sender)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function send(Envelope $envelope): Envelope
    {
        return $this->sender->send($envelope);
    }

    /**
     * {@inheritdoc}
     */
    public function get(): iterable
    {
        return $this->receiver->get();
    }

    /**
     * {@inheritdoc}
     */
    public function ack(Envelope $envelope): void
    {
        $this->receiver->ack($envelope);
    }

    /**
     * {@inheritdoc}
     */
    public function reject(Envelope $envelope): void
    {
        $this->receiver->reject($envelope);
    }
}
