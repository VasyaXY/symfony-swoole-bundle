<?php

namespace vasyaxy\Swoole\Bridge\Symfony\Bundle;

use vasyaxy\Swoole\Bridge\Symfony\Bundle\DependencyInjection\CompilerPass\DebugLogProcessorPass;
use vasyaxy\Swoole\Bridge\Symfony\Bundle\DependencyInjection\CompilerPass\StreamedResponseListenerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SwooleBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new DebugLogProcessorPass());
        $container->addCompilerPass(new StreamedResponseListenerPass());
    }
}
