<?php

declare(strict_types=1);

namespace Xver\PhpAppCoreBundle\Entity\Domain;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @template TEntity of EntityInterface
 *
 * @template-extends ArrayCollection<int, TEntity>
 *
 * @api
 */
class EntityCollection extends ArrayCollection
{
    /**
     * @param array<int, TEntity> $elements
     *
     * @psalm-suppress DocblockTypeContradiction
     * @psalm-suppress RedundantConditionGivenDocblockType
     */
    final public function __construct(private readonly array $elements = [])
    {
        foreach ($this->elements as $key => $item) {
            if (false === is_int($key)) {
                throw new \InvalidArgumentException(
                    sprintf('Key must be an integer, %s given.', gettype($key))
                );
            }
            if (false === is_a($item, $this->type())) {
                throw new \InvalidArgumentException(
                    sprintf('Found item which is not typed <%s>', $this->type())
                );
            }
        }
        parent::__construct($this->elements);
    }

    /**
     * @return class-string
     */
    public function type(): string
    {
        return EntityInterface::class;
    }

    /**
     * @return array<int, TEntity>
     */
    #[\Override]
    public function toArray(): array
    {
        return parent::toArray();
    }

    /**
     * @return false|TEntity
     */
    #[\Override]
    public function first(): EntityInterface|false
    {
        return parent::first();
    }

    /**
     * @return false|TEntity
     */
    #[\Override]
    public function last(): EntityInterface|false
    {
        return parent::last();
    }

    /**
     * @return null|TEntity
     */
    #[\Override]
    public function offsetGet(mixed $offset): ?EntityInterface
    {
        if (false === is_int($offset)) {
            throw new \InvalidArgumentException(
                sprintf('Key must be an integer, %s given.', gettype($offset))
            );
        }

        if (false === $this->containsKey($offset)) {
            return null;
        }

        /** @var null|TEntity $entity */
        $entity = parent::offsetGet($offset);
        if (false === is_a($entity, $this->type()) && null !== $entity) {
            throw new \UnexpectedValueException(
                sprintf('Expected an instance of <%s> or null, got <%s>.', $this->type(), get_debug_type($entity))
            );
        }

        return $entity;
    }

    #[\Override]
    public function contains(mixed $element): bool
    {
        if (false === is_a($element, static::type())) {
            throw new \InvalidArgumentException(
                sprintf('Found item which is not typed <%s>', $this->type())
            );
        }

        return parent::contains($element);
    }
}
