<?php

namespace vasyaxy\Swoole\Bridge\Symfony\Bundle\Command;

use Assert\Assertion;
use vasyaxy\Swoole\Server\HttpServer;
use vasyaxy\Swoole\Server\HttpServerConfiguration;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Throwable;

final class ServerStopCommand extends Command
{
    public function __construct(
        private readonly HttpServer              $server,
        private readonly HttpServerConfiguration $serverConfiguration,
        private readonly ParameterBagInterface   $parameterBag
    )
    {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this->setDescription('Stop Swoole HTTP server running in the background.')
            ->addOption('pid-file', null, InputOption::VALUE_REQUIRED, 'Pid file', $this->parameterBag->get('kernel.project_dir') . '/var/swoole.pid');
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $pidFile = $input->getOption('pid-file');
        Assertion::nullOrString($pidFile);

        $this->serverConfiguration->daemonize($pidFile);

        try {
            $this->server->shutdown();
        } catch (Throwable $ex) {
            $io->error($ex->getMessage());
            exit(1);
        }

        $io->success('Swoole server shutdown successfully');

        return 0;
    }
}
