<?php

declare(strict_types=1);

namespace Xver\PhpAppCoreBundle\Entity\Domain;

use Symfony\Component\Translation\TranslatableMessage;
use Xver\PhpAppCoreBundle\Exception\Domain\ExceptionAbstract;

/**
 * @api
 */
class EntityNotFoundException extends ExceptionAbstract
{
    public function __construct(string $entity, string $identifier, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(
            new TranslatableMessage(
                'entityNotFound',
                ['entity' => $entity, 'identifier' => $identifier],
                'PhpAppCore'
            ),
            $code,
            $previous
        );
    }
}
