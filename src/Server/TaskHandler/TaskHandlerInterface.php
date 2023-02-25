<?php

declare(strict_types=1);

namespace vasyaxy\Swoole\Server\TaskHandler;

use Swoole\Server;

interface TaskHandlerInterface
{
    /**
     * @param mixed $data
     */
    public function handle(Server $server, int $taskId, int $fromId, $data): void;
}
