<?php

declare(strict_types=1);

namespace Xver\PhpAppCoreBundle\Exception\Domain;

use Symfony\Contracts\Translation\TranslatorInterface;

final class DomainExceptionTranslator
{
    public function getTranslatedException(\Throwable $th, TranslatorInterface $translator): \Exception
    {
        $message = $this->traverseExceptionTree($th, $translator);

        return new \Exception($message, (int) $th->getCode());
    }

    public function getTranslatedExceptionAsHtml(\Throwable $th, TranslatorInterface $translator): \Exception
    {
        $message = $this->traverseExceptionTree($th, $translator);

        return new \Exception(nl2br($message), (int) $th->getCode());
    }

    private function traverseExceptionTree(
        \Throwable $th,
        TranslatorInterface $translator,
        string $message = ''
    ): string {
        $message .= $this->translateMessage($th, $translator);
        $previous = $th->getPrevious();
        if (false === is_null($previous)) {
            $message .= PHP_EOL . $this->traverseExceptionTree($previous, $translator);
        }

        return $message;
    }

    private function translateMessage(\Throwable $th, TranslatorInterface $translator): string
    {
        $message = $th->getMessage();
        if ($th instanceof DomainViolationException) {
            $message = $th->getTranslatableMessage()->trans($translator);
        }

        return $message;
    }
}
