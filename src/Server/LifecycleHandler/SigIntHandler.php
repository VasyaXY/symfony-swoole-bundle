<?php

namespace vasyaxy\Swoole\Server\LifecycleHandler;

use Swoole\Process;
use Swoole\Server;

final class SigIntHandler implements ServerStartHandlerInterface
{
    private bool $signalInterrupt;

    public function __construct(private readonly ?ServerStartHandlerInterface $decorated = null)
    {
        $this->signalInterrupt = \defined('SIGINT') ? (int) \constant('SIGINT') : 2;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Server $server): void
    {
        // 2 => SIGINT
        Process::signal($this->signalInterrupt, [$server, 'shutdown']);

        if ($this->decorated instanceof ServerStartHandlerInterface) {
            $this->decorated->handle($server);
        }
    }
}
