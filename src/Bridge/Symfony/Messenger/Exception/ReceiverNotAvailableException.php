<?php

namespace vasyaxy\Swoole\Bridge\Symfony\Messenger\Exception;

use Symfony\Component\Messenger\Exception\TransportException;

final class ReceiverNotAvailableException extends TransportException
{
    public static function make(): self
    {
        throw new self('Swoole Server Task transport does not implement Receiver interface methods. Messages sent via Swoole Server Task transport are dispatched inside task worker processes.');
    }
}
