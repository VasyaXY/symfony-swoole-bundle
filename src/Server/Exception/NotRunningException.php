<?php

namespace vasyaxy\Swoole\Server\Exception;

/**
 * @internal
 */
final class NotRunningException extends \RuntimeException
{
    public static function make(): self
    {
        return new self('Swoole HTTP Server has not been running.');
    }
}
