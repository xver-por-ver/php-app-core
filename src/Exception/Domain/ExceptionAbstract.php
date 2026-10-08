<?php

declare(strict_types=1);

namespace Xver\PhpAppCoreBundle\Exception\Domain;

use Symfony\Component\Translation\TranslatableMessage;

abstract class ExceptionAbstract extends \Exception
{
    public function __construct(
        private readonly TranslatableMessage $translatableMessage,
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($this->translatableMessage->getMessage(), $code, $previous);
    }

    public function getTranslatableMessage(): TranslatableMessage
    {
        return $this->translatableMessage;
    }
}
