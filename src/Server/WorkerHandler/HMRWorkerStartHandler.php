<?php

namespace vasyaxy\Swoole\Server\WorkerHandler;

use vasyaxy\Swoole\Server\Runtime\HMR\HotModuleReloaderInterface;
use Swoole\Server;
use Swoole\Timer;

final class HMRWorkerStartHandler implements WorkerStartHandlerInterface
{
    public function __construct(
        private readonly HotModuleReloaderInterface   $hmr,
        private readonly int                          $interval = 2000,
        private readonly ?WorkerStartHandlerInterface $decorated = null
    )
    {
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Server $worker, int $workerId): void
    {
        if ($this->decorated instanceof WorkerStartHandlerInterface) {
            $this->decorated->handle($worker, $workerId);
        }

        if ($worker->taskworker) {
            return;
        }

        Timer::tick($this->interval, function () use ($worker): void {
            $this->hmr->tick($worker);
        });

//        $worker->tick($this->interval, function () use ($worker): void {
//            $this->hmr->tick($worker);
//        });
    }
}
