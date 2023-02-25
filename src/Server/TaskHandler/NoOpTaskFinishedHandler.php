<?php

namespace vasyaxy\Swoole\Server\TaskHandler;

use Swoole\Server;

final class NoOpTaskFinishedHandler implements TaskFinishedHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function handle(Server $server, int $taskId, $data): void
    {
        // noop
    }
}
