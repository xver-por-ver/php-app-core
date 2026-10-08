<?php

declare(strict_types=1);

namespace Xver\PhpAppCoreBundle\Tests\unit\Entity\Domain;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Translation\TranslatableMessage;
use Xver\PhpAppCoreBundle\Entity\Domain\EntityNotFoundException;

/**
 * @internal
 */
#[CoversClass(EntityNotFoundException::class)]
class EntityNotFoundExceptionTest extends TestCase
{
    public function testExceptionMessageIsTranslatableMessage()
    {
        $exception = new EntityNotFoundException('User', '42');

        $this->assertInstanceOf(TranslatableMessage::class, $exception->getTranslatableMessage());
        $this->assertEquals('entityNotFound', $exception->getTranslatableMessage()->getMessage());
        $this->assertEquals(['entity' => 'User', 'identifier' => '42'], $exception->getTranslatableMessage()->getParameters());
        $this->assertEquals('PhpAppCore', $exception->getTranslatableMessage()->getDomain());
    }

    public function testExceptionCodeAndPrevious()
    {
        $previous = new \Exception('Previous');
        $exception = new EntityNotFoundException('Order', '123', 404, $previous);

        $this->assertEquals(404, $exception->getCode());
        $this->assertSame($previous, $exception->getPrevious());
    }
}
