<?php

declare(strict_types=1);

namespace Xver\PhpAppCoreBundle\Entity\Application\Query;

use Xver\PhpAppCoreBundle\Entity\Domain\EntityCollection;
use Xver\PhpAppCoreBundle\Entity\Domain\EntityInterface;

/**
 * @template TEntity of EntityInterface
 *
 * @api
 */
class EntityCollectionQueryResponse
{
    private bool $hasNextPage = false;
    private bool $hasPrevPage = false;

    /**
     * @param EntityCollection<TEntity> $collection
     */
    public function __construct(
        protected EntityCollection $collection,
        int $limit = 0,
        private readonly int $page = 0,
        private readonly int $total = 0
    ) {
        if (0 < $limit && $this->collection->count() > $limit) {
            /** @var EntityCollection<TEntity> */
            $this->collection = new EntityCollection($this->collection->slice(0, $limit));
            $this->hasNextPage = true;
        }
        $this->hasPrevPage = $this->page > 0;
    }

    /**
     * @return EntityCollection<TEntity>
     */
    public function getCollection(): EntityCollection
    {
        return $this->collection;
    }

    public function getHasNextPage(): bool
    {
        return $this->hasNextPage;
    }

    public function getHasPrevPage(): bool
    {
        return $this->hasPrevPage;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getTotal(): int
    {
        return $this->total;
    }
}
