<?php

namespace vasyaxy\Swoole\Bridge\Symfony\Messenger;

use vasyaxy\Swoole\Bridge\Symfony\Messenger\Exception\ReceiverNotAvailableException;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Receiver\ReceiverInterface;

final class SwooleServerTaskReceiver implements ReceiverInterface
{
    /**
     * {@inheritdoc}
     */
    public function get(): iterable
    {
        throw ReceiverNotAvailableException::make();
    }

    /**
     * {@inheritdoc}
     */
    public function ack(Envelope $envelope): void
    {
        throw ReceiverNotAvailableException::make();
    }

    /**
     * {@inheritdoc}
     */
    public function reject(Envelope $envelope): void
    {
        throw ReceiverNotAvailableException::make();
    }
}
