<?php

declare(strict_types=1);

namespace Xver\PhpAppCoreBundle\Tests\unit;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Xver\PhpAppCoreBundle\PhpAppCoreBundle;
use Xver\PhpAppCoreBundle\SymfonyFramework\DependencyInjection\PhpAppCoreBundleExtension;

#[CoversClass(PhpAppCoreBundle::class)]
class PhpAppCoreBundleTest extends TestCase
{
    public function testGetPathReturnsBundleRoot(): void
    {
        $bundle = new PhpAppCoreBundle();

        $this->assertSame(dirname(__DIR__, 2), $bundle->getPath());
    }

    public function testGetContainerExtensionReturnsCachedExtension(): void
    {
        $bundle = new PhpAppCoreBundle();

        $extension = $bundle->getContainerExtension();

        $this->assertInstanceOf(PhpAppCoreBundleExtension::class, $extension);
        $this->assertInstanceOf(ExtensionInterface::class, $extension);
        $this->assertSame($extension, $bundle->getContainerExtension());
    }
}
