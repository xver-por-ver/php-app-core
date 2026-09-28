<?php

namespace Xver\PhpAppCoreBundle\Entity\Domain;

/**
 * @template TEntity of EntityInterface
 * @template TFilter of EntityFilterInterface
 *
 * @api
 */
interface EntityFilterRepositoryInterface
{
    /**
     * @param TFilter $filter
     *
     * @return EntityCollection<TEntity>
     */
    public function filter(EntityFilterInterface $filter): EntityCollection;
}
