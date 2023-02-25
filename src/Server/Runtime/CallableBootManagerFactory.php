<?php

namespace vasyaxy\Swoole\Server\Runtime;

use Assert\Assertion;
use vasyaxy\Swoole\Component\GeneratedCollection;

final class CallableBootManagerFactory
{
    public function make(iterable $bootableCollection, BootableInterface ...$bootables): CallableBootManager
    {
        $objectRegistry = [];
        $isAlreadyRegistered = function (int $id) use (&$objectRegistry): bool {
            $result = !isset($objectRegistry[$id]);
            $objectRegistry[$id] = true;

            return $result;
        };

        return new CallableBootManager(
            (new GeneratedCollection($bootableCollection, ...$bootables))
                ->filter(function ($bootable) use ($isAlreadyRegistered): bool {
                    Assertion::isInstanceOf($bootable, BootableInterface::class);

                    return $isAlreadyRegistered(\spl_object_id($bootable));
                })
                ->map(fn(BootableInterface $bootable): callable => [$bootable, 'boot'])
        );
    }
}
