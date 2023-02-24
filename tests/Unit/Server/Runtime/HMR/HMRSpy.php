<?php

declare(strict_types=1);

namespace vasyaxy\Swoole\Tests\Unit\Server\Runtime\HMR;

use vasyaxy\Swoole\Server\Runtime\HMR\HotModuleReloaderInterface;
use Swoole\Server;

class HMRSpy implements HotModuleReloaderInterface
{
    public $tick = false;

    /**
     * {@inheritdoc}
     */
    public function tick(Server $server): void
    {
        $this->tick = true;
    }
}
