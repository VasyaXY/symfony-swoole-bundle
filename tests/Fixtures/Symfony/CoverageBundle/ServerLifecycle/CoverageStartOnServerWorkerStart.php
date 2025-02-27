<?php

declare(strict_types=1);

namespace vasyaxy\Swoole\Tests\Fixtures\Symfony\CoverageBundle\ServerLifecycle;

use vasyaxy\Swoole\Server\WorkerHandler\WorkerStartHandlerInterface;
use vasyaxy\Swoole\Tests\Fixtures\Symfony\CoverageBundle\Coverage\CodeCoverageManager;
use Swoole\Server;

final class CoverageStartOnServerWorkerStart implements WorkerStartHandlerInterface
{
    private $codeCoverageManager;
    private $decorated;

    public function __construct(CodeCoverageManager $codeCoverageManager, ?WorkerStartHandlerInterface $decorated = null)
    {
        $this->codeCoverageManager = $codeCoverageManager;
        $this->decorated = $decorated;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Server $worker, int $workerId): void
    {
        $this->codeCoverageManager->start(\sprintf('test_worker_%d', $workerId));

        if ($this->decorated instanceof WorkerStartHandlerInterface) {
            $this->decorated->handle($worker, $workerId);
        }
    }
}
