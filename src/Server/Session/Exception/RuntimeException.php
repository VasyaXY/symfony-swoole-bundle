<?php

namespace vasyaxy\Swoole\Server\Session\Exception;

use RuntimeException as PHPRuntimeException;

final class RuntimeException extends PHPRuntimeException implements SessionExceptionInterface
{
}
