<?php

namespace vasyaxy\Swoole\Bridge\Symfony\Bundle\Exception;

/**
 * @internal
 */
final class CouldNotCreatePidFileException extends \RuntimeException
{
    public static function forPath(string $pidFile): self
    {
        throw new self(\sprintf('Could not create pid file "%s".', $pidFile));
    }
}
