<?php

declare(strict_types=1);

namespace Xver\PhpAppCoreBundle\Tests\unit\Entity\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Xver\PhpAppCoreBundle\Entity\Domain\EntityCollection;
use Xver\PhpAppCoreBundle\Entity\Domain\EntityInterface;

/**
 * @internal
 */
#[CoversClass(EntityCollection::class)]
class EntityCollectionTest extends TestCase
{
    #[DataProvider('invalidKeys')]
    public function testInvalidCollectionKeyThrowsException($key): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Key must be an integer, %s given.', gettype($key)));
        new EntityCollection([$key => $this->createStub(EntityInterface::class)]);
    }

    public static function invalidKeys(): array
    {
        return [
            [''],
            ['key'],
        ];
    }

    #[DataProvider('invalidTypes')]
    public function testInvalidCollectionTypesThrowsException($array): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Found item which is not typed <%s>', EntityInterface::class));
        new EntityCollection($array);
    }

    public static function invalidTypes(): array
    {
        return [
            [[1]],
            [[new \stdClass()]],
        ];
    }

    public function testConstructorArgumentIsEmptyArray(): void
    {
        $entityObjectCollectionMock = new EntityCollection([]);
        $this->assertInstanceOf(EntityCollection::class, $entityObjectCollectionMock);
        $this->assertInstanceOf(ArrayCollection::class, $entityObjectCollectionMock);
    }

    public function testContructorAndGetters(): void
    {
        $entity1 = $this->createStub(EntityInterface::class);
        $entity2 = $this->createStub(EntityInterface::class);
        $entityObjectsArray = [
            $entity1, $entity2,
        ];
        $entityObjectCollection = new EntityCollection($entityObjectsArray);
        $this->assertInstanceOf(EntityCollection::class, $entityObjectCollection);
        $this->assertInstanceOf(ArrayCollection::class, $entityObjectCollection);
        $this->assertIsArray($entityObjectCollection->toArray());
        $this->assertSame($entity1, $entityObjectCollection->first());
        $this->assertSame($entity2, $entityObjectCollection->last());
        $this->assertSame($entity1, $entityObjectCollection->offsetGet(0));
        $this->assertSame($entity2, $entityObjectCollection->offsetGet(1));
        $this->assertTrue($entityObjectCollection->contains($entity1));
        $this->assertTrue($entityObjectCollection->contains($entity2));
    }

    public function testOffsetGetWithNonIntThrowsException(): void
    {
        $entityObjectCollection = new EntityCollection([]);
        $this->expectException(\InvalidArgumentException::class);
        $entityObjectCollection->offsetGet('1');
    }

    public function testOffsetGetWithInvalidOffsetReturnsNull(): void
    {
        $entityObjectCollection = new EntityCollection([]);
        $this->assertNull($entityObjectCollection->offsetGet(1));
    }

    public function testOffsetGetWithInvalidItemThrowsUnexpectedValueException(): void
    {
        $entityObjectCollection = new EntityCollection([]);
        $entityObjectCollection->set(0, new \stdClass());

        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessageIs(sprintf(
            'Expected an instance of <%s> or null, got <%s>.',
            EntityInterface::class,
            \stdClass::class,
        ));
        $entityObjectCollection->offsetGet(0);
    }

    public function testContainsWithInvalidArgumentThrowsException(): void
    {
        $entityObjectCollection = new EntityCollection([]);
        $this->expectException(\InvalidArgumentException::class);
        $entityObjectCollection->contains('1');
    }

    public function testContainsLateStaticBinding(): void
    {
        $entityObjectCollection = new class extends EntityCollection {
            public function type(): string
            {
                return \stdClass::class;
            }
        };
        $entity = new \stdClass();
        $entityObjectCollection->contains($entity);
        $this->expectNotToPerformAssertions();
    }
}
