<?php

namespace vasyaxy\Swoole\Server\Runtime;

use Assert\Assertion;

/**
 * Chain of services implementing BootableInterface.
 */
final class CallableBootManager implements BootableInterface
{
    /**
     * @param iterable<callable> $bootables
     */
    public function __construct(private iterable $bootables, private bool $booted = false)
    {
    }

    /**
     * {@inheritdoc}
     *
     * Method MUST be called directly before Swoole server start.
     *
     * @throws \Assert\AssertionFailedException When already booted
     */
    public function boot(array $runtimeConfiguration = []): void
    {
        Assertion::false($this->booted, 'Boot method has already been called. Cannot boot services multiple times.');
        $this->booted = true;

        /** @var callable $bootable */
        foreach ($this->bootables as $bootable) {
            $bootable($runtimeConfiguration);
        }
    }
}
