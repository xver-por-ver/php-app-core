<?php

declare(strict_types=1);

namespace Xver\PhpAppCoreBundle\Tests\unit\SymfonyFramework\DependencyInjection;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Xver\PhpAppCoreBundle\Exception\Domain\DomainExceptionTranslator;
use Xver\PhpAppCoreBundle\SymfonyFramework\DependencyInjection\PhpAppCoreBundleExtension;

#[CoversClass(PhpAppCoreBundleExtension::class)]
class PhpAppCoreBundleExtensionTest extends TestCase
{
    public function testLoadRegistersServicesFromConfiguration(): void
    {
        $container = new ContainerBuilder();

        new PhpAppCoreBundleExtension()->load([], $container);

        $this->assertTrue($container->hasDefinition(DomainExceptionTranslator::class));
    }
}
