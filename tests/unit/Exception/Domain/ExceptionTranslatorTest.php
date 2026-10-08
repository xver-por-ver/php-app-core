<?php

declare(strict_types=1);

namespace Xver\PhpAppCoreBundle\Tests\unit\Exception\Domain;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Translation\TranslatableMessage;
use Symfony\Contracts\Translation\TranslatorInterface;
use Xver\PhpAppCoreBundle\Exception\Domain\DomainExceptionTranslator;
use Xver\PhpAppCoreBundle\Exception\Domain\DomainViolationException;
use Xver\PhpAppCoreBundle\Exception\Domain\ExceptionAbstract;

/**
 * @internal
 */
#[CoversClass(DomainExceptionTranslator::class)]
#[UsesClass(DomainViolationException::class)]
#[UsesClass(ExceptionAbstract::class)]
class ExceptionTranslatorTest extends TestCase
{
    public function testNonTranslatableException(): void
    {
        $prevExceptionMsg = 'Im the multiline previous exception.' . PHP_EOL . 'message.';
        $prevExceptionMsgHtml = nl2br($prevExceptionMsg);
        $prevException = new \Exception($prevExceptionMsg);
        $exceptionMsg = 'Im the thrown multiline exception' . PHP_EOL . 'message.';
        $exceptionMsgHtml = nl2br($exceptionMsg);
        $exception = new \Exception($exceptionMsg, 0, $prevException);
        $translator = $this->createStub(TranslatorInterface::class);

        $exceptionTranslator = new DomainExceptionTranslator();
        $translatedException = $exceptionTranslator->getTranslatedException($exception, $translator);
        $this->assertInstanceOf(\Exception::class, $translatedException);
        $this->assertSame($exceptionMsg . PHP_EOL . $prevExceptionMsg, $translatedException->getMessage());
        $translatedException = $exceptionTranslator->getTranslatedExceptionAsHtml($exception, $translator);
        $this->assertInstanceOf(\Exception::class, $translatedException);
        $this->assertSame($exceptionMsgHtml . nl2br(PHP_EOL) . $prevExceptionMsgHtml, $translatedException->getMessage());
    }

    public function testTranslatableException(): void
    {
        $exceptionMsg = 'exception message';
        $exception = new DomainViolationException(
            new TranslatableMessage(
                $exceptionMsg
            )
        );
        $translator = $this->createStub(TranslatorInterface::class);
        $translator->method('trans')->willReturn($exceptionMsg);

        $exceptionTranslator = new DomainExceptionTranslator();
        $translatedException = $exceptionTranslator->getTranslatedException($exception, $translator);
        $this->assertInstanceOf(\Exception::class, $translatedException);
        $this->assertSame($exceptionMsg, $translatedException->getMessage());
        $translatedException = $exceptionTranslator->getTranslatedExceptionAsHtml($exception, $translator);
        $this->assertInstanceOf(\Exception::class, $translatedException);
        $this->assertSame($exceptionMsg, $translatedException->getMessage());
    }
}
