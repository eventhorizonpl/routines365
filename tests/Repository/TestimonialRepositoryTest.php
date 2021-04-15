<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Entity\Testimonial;
use App\Faker\UserFaker;
use App\Manager\TestimonialManager;
use App\Repository\TestimonialRepository;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @internal
 */
final class TestimonialRepositoryTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ManagerRegistry $managerRegistry;
    /**
     * @inject
     */
    private ?TestimonialManager $testimonialManager;
    /**
     * @inject
     */
    private ?TestimonialRepository $testimonialRepository;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        $this->managerRegistry = null;
        $this->testimonialManager = null;
        $this->testimonialRepository = null;
        $this->userFaker = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $testimonialRepository = new TestimonialRepository($this->managerRegistry);

        $this->assertInstanceOf(TestimonialRepository::class, $testimonialRepository);
    }

    public function testFindByParametersForAdmin(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $testimonials = $this->testimonialRepository->findByParametersForAdmin()->getResult();
        $this->assertCount(1, $testimonials);
        $this->assertIsArray($testimonials);

        $parameters = [
            'query' => $user->getEmail(),
        ];
        $testimonials = $this->testimonialRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $testimonials);
        $this->assertIsArray($testimonials);

        $parameters = [
            'status' => 'wrong',
        ];
        $testimonials = $this->testimonialRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $testimonials);
        $this->assertIsArray($testimonials);

        $parameters = [
            'query' => 'wrong email',
        ];
        $testimonials = $this->testimonialRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $testimonials);
        $this->assertIsArray($testimonials);

        $parameters = [
            'ends_at' => new DateTimeImmutable('NOW'),
        ];
        $testimonials = $this->testimonialRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $testimonials);
        $this->assertIsArray($testimonials);

        $parameters = [
            'starts_at' => new DateTimeImmutable('+1 minute'),
        ];
        $testimonials = $this->testimonialRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $testimonials);
        $this->assertIsArray($testimonials);
    }

    public function testFindOneRand(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $testimonial = $user->getTestimonial();
        $testimonial->setIsVisible(true);
        $testimonial->setStatus(Testimonial::STATUS_ACCEPTED);
        $this->testimonialManager->save($testimonial, (string) $user);

        $testimonial = $this->testimonialRepository->findOneRand();
        $this->assertInstanceOf(Testimonial::class, $testimonial);
    }
}
