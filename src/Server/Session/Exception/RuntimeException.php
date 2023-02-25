<?php

declare(strict_types=1);

namespace vasyaxy\Swoole\Server\Session\Exception;

use RuntimeException as PHPRuntimeException;

final class RuntimeException extends PHPRuntimeException implements SessionExceptionInterface
{
}
