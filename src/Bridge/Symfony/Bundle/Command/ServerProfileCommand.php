<?php

namespace vasyaxy\Swoole\Bridge\Symfony\Bundle\Command;

use Assert\Assertion;
use vasyaxy\Swoole\Server\HttpServerConfiguration;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

final class ServerProfileCommand extends AbstractServerStartCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this->setDescription('Handle specified amount of requests to Swoole HTTP server. Useful for profiling.')
            ->addArgument('requests', InputArgument::REQUIRED, 'Number of requests to handle by the server');

        parent::configure();
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     */
    protected function prepareRuntimeConfiguration(HttpServerConfiguration $serverConfiguration, InputInterface $input): array
    {
        $requestLimit = $input->getArgument('requests');
        Assertion::numeric($requestLimit);
        Assertion::greaterOrEqualThan($requestLimit, 0, 'Request limit must be greater than 0');

        return ['requestLimit' => $requestLimit] + parent::prepareRuntimeConfiguration($serverConfiguration, $input);
    }

    /**
     * {@inheritdoc}
     */
    protected function prepareConfigurationRowsToPrint(HttpServerConfiguration $serverConfiguration, array $runtimeConfiguration): array
    {
        $rows = parent::prepareConfigurationRowsToPrint($serverConfiguration, $runtimeConfiguration);
        $rows[] = ['request_limit', $runtimeConfiguration['requestLimit'] > 0 ? $runtimeConfiguration['requestLimit'] : -1];

        return $rows;
    }
}
