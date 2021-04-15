<?php

declare(strict_types=1);

namespace App\ApiPlatform;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\Note;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;

class NoteListingExtension implements QueryCollectionExtensionInterface
{
    public function __construct(
        private Security $security
    ) {
    }

    public function applyToCollection(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        string $operationName = null
    ): void {
        if (Note::class !== $resourceClass) {
            return;
        }

        $rootAlias = $queryBuilder->getRootAliases()[0];

        $queryBuilder
            ->andWhere(sprintf('%s.deletedAt IS NULL', $rootAlias))
            ->andWhere(sprintf('%s.user = :user', $rootAlias))
            ->setParameter('user', $this->security->getUser())
        ;
    }
}
