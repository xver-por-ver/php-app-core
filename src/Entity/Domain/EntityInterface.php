<?php

declare(strict_types=1);

namespace Xver\PhpAppCoreBundle\Entity\Domain;

interface EntityInterface
{
    public function sameId(EntityInterface $otherEntity): bool;
}
