<?php

declare(strict_types=1);

namespace vasyaxy\Swoole\Tests\Unit\Component\AtomicCounter;

use Swoole\Atomic;

final class AtomicSpy extends Atomic
{
    public $incremented = false;

    public function __construct()
    {
        parent::__construct(0);
    }

    public function add($add_value = null): int
    {
        $this->incremented = 1 === $add_value;
        return 0;
    }
}
