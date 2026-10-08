<?php

declare(strict_types=1);

namespace Xver\PhpAppCoreBundle\Exception\Domain;

use Symfony\Component\Translation\TranslatableMessage;

final class DomainViolationException extends ExceptionAbstract
{
    public function __construct(
        private readonly TranslatableMessage $translatableViolationMessage,
        private ?string $domainEntail = null,
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        if ('' === $this->domainEntail) {
            $this->domainEntail = null;
        }
        parent::__construct($this->translatableViolationMessage, $code, $previous);
    }

    public function getDomainEntail(): ?string
    {
        return $this->domainEntail;
    }
}
