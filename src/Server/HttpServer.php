<?php

namespace vasyaxy\Swoole\Server;

use Swoole\Coroutine;
use vasyaxy\Swoole\Server\Exception\IllegalInitializationException;
use vasyaxy\Swoole\Server\Exception\NotRunningException;
use vasyaxy\Swoole\Server\Exception\PortUnavailableException;
use vasyaxy\Swoole\Server\Exception\UnexpectedPortException;
use vasyaxy\Swoole\Server\Exception\UninitializedException;
use Swoole\Http\Server;
use Swoole\Process;
use Swoole\Server\Port as Listener;
use Swoole\Coroutine as Co;
use Throwable;

final class HttpServer
{
    public const GRACEFUL_SHUTDOWN_TIMEOUT_SECONDS = 10;

    /**
     * @var null|Server
     */
    private null|Server $server = null;

    /**
     * @var Listener[]
     */
    private array $listeners = [];
    private bool $signalTerminate;
    private bool $signalReload;
    private bool $signalKill;

    public function __construct(
        private readonly HttpServerConfiguration $configuration,
        private bool $running = false
    )
    {
        $this->signalTerminate = \defined('SIGTERM') ? (int) \constant('SIGTERM') : 15;
        $this->signalReload = \defined('SIGUSR1') ? (int) \constant('SIGUSR1') : 10;
        $this->signalKill = \defined('SIGKILL') ? (int) \constant('SIGKILL') : 9;
    }

    /**
     * Attach already configured Swoole HTTP Server instance.
     */
    public function attach(Server $server): void
    {
        $this->assertNotInitialized();
        $this->assertInstanceConfiguredProperly($server);

        $this->server = $server;
        $defaultSocketPort = $this->configuration->getServerSocket()->port();

        foreach ($server->ports as $listener) {
            if ($listener->port === $defaultSocketPort) {
                continue;
            }

            $this->assertPortAvailable($this->listeners, $listener->port);
            $this->listeners[$listener->port] = $listener;
        }
    }

    public function start(): bool
    {
        return $this->running = $this->getServer()->start();
    }

    /**
     * @throws \Assert\AssertionFailedException
     * @throws NotRunningException
     */
    public function shutdown(): void
    {
        if ($this->server instanceof Server) {
            $this->server->shutdown();
        } elseif ($this->isRunningInBackground()) {
            $this->gracefulSignalShutdown($this->configuration->getPid(), self::GRACEFUL_SHUTDOWN_TIMEOUT_SECONDS);
        } else {
            throw NotRunningException::make();
        }
    }

    /**
     * @throws \Assert\AssertionFailedException
     * @throws NotRunningException
     */
    public function reload(): void
    {
        if ($this->server instanceof Server) {
            $this->server->reload();
        } elseif ($this->isRunningInBackground()) {
            Process::kill($this->configuration->getPid(), $this->signalReload);
        } else {
            throw NotRunningException::make();
        }
    }

    public function metrics(): array
    {
        return $this->getServer()->stats();
    }

    public function isRunning(): bool
    {
        return $this->running || $this->isRunningInBackground();
    }

    public function getServer(): Server
    {
        if (null === $this->server) {
            throw UninitializedException::make();
        }

        return $this->server;
    }

    /**
     * @param mixed $data
     */
    public function dispatchTask(mixed $data): void
    {
        $this->getServer()->task($data);
    }

    /**
     * @return Listener[]
     */
    public function getListeners(): array
    {
        return $this->listeners;
    }

    private function isRunningInBackground(): bool
    {
        try {
            return Process::kill($this->configuration->getPid(), 0);
        } catch (Throwable $ex) {
            return false;
        }
    }

    private function assertNotInitialized(): void
    {
        if (null === $this->server) {
            return;
        }

        throw IllegalInitializationException::make();
    }

    private function assertInstanceConfiguredProperly(Server $server): void
    {
        $defaultSocket = $this->configuration->getServerSocket();

        if ($defaultSocket->port() !== $server->port) {
            throw UnexpectedPortException::with($server->port, $defaultSocket->port());
        }
    }

    private function assertPortAvailable(array $listeners, int $port): void
    {
        if (false === \array_key_exists($port, $listeners)) {
            return;
        }

        throw PortUnavailableException::fortPort($port);
    }

    private function gracefulSignalShutdown(int $masterPid, float $timeoutSeconds): void
    {
        Process::kill($masterPid, $this->signalTerminate);

        $start = $now = \microtime(true);
        $max = $start + $timeoutSeconds;
        while ($this->isRunningInBackground() && $now < $max) {
            $now = \microtime(true);
            \usleep(1000);
        }

        if ($this->isRunningInBackground()) {
            Process::kill($masterPid, $this->signalKill);
        }
    }
}
