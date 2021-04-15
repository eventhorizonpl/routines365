<?php

declare(strict_types=1);

namespace App\ApiPlatform;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\Quote;
use Doctrine\ORM\QueryBuilder;

class QuoteListingExtension implements QueryCollectionExtensionInterface
{
    public function applyToCollection(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        string $operationName = null
    ): void {
        if (Quote::class !== $resourceClass) {
            return;
        }

        $rootAlias = $queryBuilder->getRootAliases()[0];

        $queryBuilder
            ->andWhere(sprintf('%s.deletedAt IS NULL', $rootAlias))
            ->andWhere(sprintf('%s.isVisible = :isVisible', $rootAlias))
            ->setParameter('isVisible', true)
        ;
    }
}
