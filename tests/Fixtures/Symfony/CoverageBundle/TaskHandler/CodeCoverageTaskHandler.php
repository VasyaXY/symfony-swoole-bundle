<?php

declare(strict_types=1);

namespace vasyaxy\Swoole\Tests\Fixtures\Symfony\CoverageBundle\TaskHandler;

use vasyaxy\Swoole\Server\TaskHandler\TaskHandlerInterface;
use vasyaxy\Swoole\Tests\Fixtures\Symfony\CoverageBundle\Coverage\CodeCoverageManager;
use Swoole\Server;

final class CodeCoverageTaskHandler implements TaskHandlerInterface
{
    private $decorated;
    private $codeCoverageManager;

    public function __construct(TaskHandlerInterface $decorated, CodeCoverageManager $codeCoverageManager)
    {
        $this->decorated = $decorated;
        $this->codeCoverageManager = $codeCoverageManager;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Server $server, int $taskId, int $fromId, $data): void
    {
        $testName = \sprintf('test_task_%d_%d_%s', $taskId, $fromId, \bin2hex(\random_bytes(4)));
        $this->codeCoverageManager->start($testName);

        $this->decorated->handle($server, $taskId, $fromId, $data);

        $this->codeCoverageManager->stop();
        $this->codeCoverageManager->finish($testName);
    }
}
