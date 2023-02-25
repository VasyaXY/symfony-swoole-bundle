<?php

namespace vasyaxy\Swoole\Server\WorkerHandler;

use Swoole\Server;

final class NoOpWorkerStartHandler implements WorkerStartHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function handle(Server $worker, int $workerId): void
    {
        // noop
    }
}
