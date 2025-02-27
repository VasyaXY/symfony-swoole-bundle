<?php

namespace vasyaxy\Swoole\Server\Exception;

/**
 * @internal
 */
final class UnexpectedPortException extends \InvalidArgumentException
{
    public static function with(int $port, int $expectedPort): self
    {
        return new self(\sprintf('Attached Swoole HTTP Server has different port (%s), than expected (%s).', $port, $expectedPort));
    }
}
