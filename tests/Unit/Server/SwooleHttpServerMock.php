<?php

namespace vasyaxy\Swoole\Tests\Unit\Server;

use Swoole\Http\Server;

final class SwooleHttpServerMock extends Server
{
    public bool $registeredEvent = false;
    public array $registeredEventPair = [];
    private static self $instance;

    private function __construct()
    {
        parent::__construct('localhost', 31999);
    }

    public function on($event_name, $callback): bool
    {
        $this->registeredEvent = true;
        $this->registeredEventPair = [$event_name, $callback];
    }

    public static function make(): self
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }

        self::$instance->clean();

        return self::$instance;
    }

    private function clean(): void
    {
        $this->registeredEvent = false;
        $this->registeredEventPair = [];
    }
}
