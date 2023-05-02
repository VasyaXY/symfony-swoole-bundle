<?php

namespace vasyaxy\Swoole\Server\LifecycleHandler;

use Swoole\Process;
use Swoole\Server;

final class SigIntHandler implements ServerStartHandlerInterface
{
    private int $signalInterrupt;
//    private int $signalHup;

    public function __construct(private readonly ?ServerStartHandlerInterface $decorated = null)
    {
        $this->signalInterrupt = \defined('SIGINT') ? (int) \constant('SIGINT') : 2;
//        $this->signalHup = \defined('SIGHUP') ? (int) \constant('SIGHUP') : 1;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Server $server): void
    {
        // 2 => SIGINT
        Process::signal($this->signalInterrupt, [$server, 'shutdown']);
//        Process::signal($this->signalHup, [$server, 'shutdown']);

        if ($this->decorated instanceof ServerStartHandlerInterface) {
            $this->decorated->handle($server);
        }
    }
}
