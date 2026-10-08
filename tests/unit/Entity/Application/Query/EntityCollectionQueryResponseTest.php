<?php

declare(strict_types=1);

namespace Xver\PhpAppCoreBundle\Tests\unit\Entity\Application\Query;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Xver\PhpAppCoreBundle\Entity\Application\Query\EntityCollectionQueryResponse;
use Xver\PhpAppCoreBundle\Entity\Domain\EntityCollection;
use Xver\PhpAppCoreBundle\Entity\Domain\EntityInterface;

/**
 * @internal
 */
#[CoversClass(EntityCollectionQueryResponse::class)]
#[UsesClass(EntityCollection::class)]
class EntityCollectionQueryResponseTest extends TestCase
{
    #[DataProvider('dataQueryResponse')]
    public function testQueryResponse(int $arrayItemsAmount, int $limit, int $page, int $count, bool $hasPrevPage, bool $hasNextPage): void
    {
        $entitiesArray = [];
        for ($i = 0; $i < $arrayItemsAmount; ++$i) {
            $entitiesArray[] = $this->createStub(EntityInterface::class);
        }
        $entityObjectsCollection = new EntityCollection($entitiesArray);
        $queryResponse = new EntityCollectionQueryResponse(
            $entityObjectsCollection,
            $limit,
            $page,
            $arrayItemsAmount
        );
        $this->assertInstanceOf(EntityCollection::class, $queryResponse->getCollection());
        $this->assertSame($count, $queryResponse->getCollection()->count());
        $this->assertSame($page, $queryResponse->getPage());
        $this->assertSame($hasPrevPage, $queryResponse->getHasPrevPage());
        $this->assertSame($hasNextPage, $queryResponse->getHasNextPage());
        $this->assertSame($arrayItemsAmount, $queryResponse->getTotal());
    }

    public static function dataQueryResponse(): array
    {
        return [
            [0, 2, 0, 0, false, false],
            [3, 2, 0, 2, false, true],
            [3, 2, 1, 2, true, true],
            [1, 2, 2, 1, true, false],
            [5, 5, 0, 5, false, false],
        ];
    }
}
