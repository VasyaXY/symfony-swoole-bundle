<?php

namespace vasyaxy\Swoole\Server\TaskHandler;

use Swoole\Server;

final class NoOpTaskHandler implements TaskHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function handle(Server $server, int $taskId, int $fromId, $data): void
    {
        // noop
    }
}
