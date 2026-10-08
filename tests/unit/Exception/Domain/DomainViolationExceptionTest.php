<?php

declare(strict_types=1);

namespace Xver\PhpAppCoreBundle\Tests\unit\Exception\Domain;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Translation\TranslatableMessage;
use Xver\PhpAppCoreBundle\Exception\Domain\DomainViolationException;

/**
 * @internal
 */
#[CoversClass(DomainViolationException::class)]
class DomainViolationExceptionTest extends TestCase
{
    public function testConstructorAndGetters(): void
    {
        $translatableMessage = new TranslatableMessage('Violation occurred');
        $domainEntail = 'Some domain entail';
        $exception = new DomainViolationException($translatableMessage, $domainEntail);

        $this->assertSame($translatableMessage, $exception->getTranslatableMessage());
        $this->assertSame($domainEntail, $exception->getDomainEntail());
        $this->assertSame('Violation occurred', $exception->getMessage());
    }

    public function testConstructorWithEmptyDomainEntail(): void
    {
        $translatableMessage = new TranslatableMessage('Violation occurred');
        $exception = new DomainViolationException($translatableMessage, '');

        $this->assertSame($translatableMessage, $exception->getTranslatableMessage());
        $this->assertNull($exception->getDomainEntail());
        $this->assertSame('Violation occurred', $exception->getMessage());
    }

    public function testConstructorWithNullDomainEntail(): void
    {
        $translatableMessage = new TranslatableMessage('Violation occurred');
        $exception = new DomainViolationException($translatableMessage, null);

        $this->assertSame($translatableMessage, $exception->getTranslatableMessage());
        $this->assertNull($exception->getDomainEntail());
        $this->assertSame('Violation occurred', $exception->getMessage());
    }

    public function testConstructorWithPreviousException(): void
    {
        $translatableMessage = new TranslatableMessage('Violation occurred');
        $previousException = new \RuntimeException('Previous exception');
        $exception = new DomainViolationException($translatableMessage, null, 0, $previousException);

        $this->assertSame($previousException, $exception->getPrevious());
    }
}
