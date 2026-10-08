<?php

declare(strict_types=1);

namespace Xver\PhpAppCoreBundle;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Kernel\AbstractBundle;
use Xver\PhpAppCoreBundle\SymfonyFramework\DependencyInjection\PhpAppCoreBundleExtension;

final class PhpAppCoreBundle extends AbstractBundle
{
    #[\Override]
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    #[\Override]
    public function getContainerExtension(): ?ExtensionInterface
    {
        if (null === $this->extension) {
            $this->extension = new PhpAppCoreBundleExtension();
        }

        return $this->extension ?: null;
    }
}
