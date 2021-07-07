<?php

declare(strict_types=1);

namespace App\Tests\ApiPlatform;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGenerator;
use App\ApiPlatform\NoteListingExtension;
use App\Entity\{Note, User};
use App\Faker\UserFaker;
use App\Repository\NoteRepository;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\Security\Core\Security;

/**
 * @internal
 */
final class NoteListingExtensionTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?NoteRepository $noteRepository;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;
    /**
     * @inject
     */
    private ?Security $security;

    protected function tearDown(): void
    {
        $this->noteRepository = null;
        $this->userFaker = null;
        $this->security = null;

        parent::tearDown();
    }

    public function createNote(): Note
    {
        $user = $this->userFaker->createRichUserPersisted();

        return $user->getNotes()->first();
    }

    public function testConstruct(): void
    {
        $noteListingExtension = new NoteListingExtension($this->security);

        $this->assertInstanceOf(NoteListingExtension::class, $noteListingExtension);
    }

    public function testApplyToCollection(): void
    {
        $this->purge();
        $note = $this->createNote();
        $user = $note->getUser();

        $queryBuilder = $this->noteRepository->createQueryBuilder('n');
        $queryNameGenerator = new QueryNameGenerator();
        $security = $this->createStub(Security::class);
        $security->method('getUser')
            ->willReturn($user)
        ;

        $noteListingExtension = new NoteListingExtension($security);

        $this->assertNull($noteListingExtension->applyToCollection($queryBuilder, $queryNameGenerator, Note::class));
        $this->assertNull($noteListingExtension->applyToCollection($queryBuilder, $queryNameGenerator, User::class));
    }
}
