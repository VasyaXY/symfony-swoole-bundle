<?php

declare(strict_types=1);

namespace vasyaxy\Swoole\Bridge\Symfony\Bundle\Command;

final class ServerRunCommand extends AbstractServerStartCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this->setDescription('Run Swoole HTTP server.');

        parent::configure();
    }
}
