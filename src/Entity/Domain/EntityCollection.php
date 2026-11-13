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
    private const string INVALID_KEY_TYPE_MSG = 'Key must be an integer, %s given.';
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
                    sprintf(self::INVALID_KEY_TYPE_MSG, gettype($key))
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
                sprintf(self::INVALID_KEY_TYPE_MSG, gettype($offset))
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
        $this->assertEntityType($element);

        return parent::contains($element);
    }

    #[\Override]
    public function add(mixed $element): void
    {
        $this->assertEntityType($element);
        parent::add($element);
    }

    /**
     * @psalm-suppress DocblockTypeContradiction
     * @psalm-suppress RedundantConditionGivenDocblockType
     */
    #[\Override]
    public function set(string|int $key, mixed $value): void
    {
        if (false === is_int($key)) {
            throw new \InvalidArgumentException(
                sprintf(self::INVALID_KEY_TYPE_MSG, gettype($key))
            );
        }
        $this->assertEntityType($value);
        parent::set($key, $value);
    }

    /**
     * @psalm-suppress DocblockTypeContradiction
     * @psalm-suppress RedundantConditionGivenDocblockType
     */
    #[\Override]
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (null === $offset) {
            $this->add($value);

            return;
        }
        if (false === is_int($offset)) {
            throw new \InvalidArgumentException(
                sprintf(self::INVALID_KEY_TYPE_MSG, gettype($offset))
            );
        }
        $this->set($offset, $value);
    }

    private function assertEntityType(mixed $entity): void
    {
        if (false === is_a($entity, $this->type())) {
            throw new \InvalidArgumentException(
                sprintf('Found item which is not typed <%s>', $this->type())
            );
        }
    }
}
