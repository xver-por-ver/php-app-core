<?php

namespace Xver\PhpAppCoreBundle\Entity\Domain;

/**
 * @template TEntity of EntityInterface
 * @template TFilter of EntityFilterInterface
 */
interface EntityRepositoryInterface
{
    /**
     * @param TFilter $filter
     *
     * @return EntityCollection<TEntity>
     */
    public function matching(EntityFilterInterface $filter): EntityCollection;

    /**
     * @param TFilter $filter
     */
    public function countMatching(EntityFilterInterface $filter): int;

    /**
     * Mark entity to be persisted into datastore when flush is invoked.
     *
     * @param TEntity $entity
     */
    public function persist(EntityInterface $entity): self;

    /**
     * Persist entity into datastore.
     */
    public function flush(): self;

    /**
     * Initiate a transaction.
     */
    public function beginTransaction(): self;

    /**
     * Commit initiated transaction.
     */
    public function commit(): self;

    /**
     * Rollback.
     */
    public function rollBack(): self;

    /**
     * Mark entity to be removed from datastore when flush is invoked.
     *
     * @param TEntity $entity
     */
    public function remove(EntityInterface $entity): self;
}
