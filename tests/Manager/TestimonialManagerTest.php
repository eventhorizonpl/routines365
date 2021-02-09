<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\Testimonial;
use App\Exception\ManagerException;
use App\Faker\UserFaker;
use App\Manager\TestimonialManager;
use App\Repository\TestimonialRepository;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class TestimonialManagerTest extends AbstractDoctrineTestCase
{
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
    /**
     * @inject
     */
    private ?ValidatorInterface $validator;

    protected function tearDown(): void
    {
        unset(
            $this->testimonialManager,
            $this->testimonialRepository,
            $this->userFaker,
            $this->validator
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $testimonialManager = new TestimonialManager(
            $this->entityManager,
            $this->validator
        );

        $this->assertInstanceOf(TestimonialManager::class, $testimonialManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $content = 'test content';
        $testimonial = $user->getTestimonial();
        $testimonial->setContent($content);
        $testimonialId = $testimonial->getId();
        $testimonials = [];
        $testimonials[] = $testimonial;

        $testimonialManager = $this->testimonialManager->bulkSave($testimonials, (string) $user, 1);
        $this->assertInstanceOf(TestimonialManager::class, $testimonialManager);

        $testimonial2 = $this->testimonialRepository->findOneById($testimonialId);
        $this->assertInstanceOf(Testimonial::class, $testimonial2);
        $this->assertEquals($content, $testimonial2->getContent());
    }

    public function testDelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $testimonial = $user->getTestimonial();
        $testimonialId = $testimonial->getId();

        $testimonialManager = $this->testimonialManager->delete($testimonial);
        $this->assertInstanceOf(TestimonialManager::class, $testimonialManager);

        $testimonial2 = $this->testimonialRepository->findOneById($testimonialId);
        $this->assertNull($testimonial2);
    }

    public function testSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $testimonial = $user->getTestimonial();

        $testimonialManager = $this->testimonialManager->save($testimonial, (string) $user, true);
        $this->assertInstanceOf(TestimonialManager::class, $testimonialManager);

        $testimonialManager = $this->testimonialManager->save($testimonial, (string) $user, true);
        $this->assertInstanceOf(TestimonialManager::class, $testimonialManager);
    }

    public function testSaveException(): void
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $testimonial = $user->getTestimonial();
        $testimonial->setUuid('wrong');

        $testimonialManager = $this->testimonialManager->save($testimonial, (string) $user, true);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $testimonial = $user->getTestimonial();
        $testimonialId = $testimonial->getId();

        $testimonialManager = $this->testimonialManager->softDelete($testimonial, (string) $user);
        $this->assertInstanceOf(TestimonialManager::class, $testimonialManager);

        $testimonial2 = $this->testimonialRepository->findOneById($testimonialId);
        $this->assertInstanceOf(Testimonial::class, $testimonial2);
        $this->assertTrue(null !== $testimonial2->getDeletedAt());
    }

    public function testUndelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $testimonial = $user->getTestimonial();
        $testimonialId = $testimonial->getId();

        $testimonialManager = $this->testimonialManager->softDelete($testimonial, (string) $user);
        $this->assertInstanceOf(TestimonialManager::class, $testimonialManager);

        $testimonial2 = $this->testimonialRepository->findOneById($testimonialId);
        $this->assertInstanceOf(Testimonial::class, $testimonial2);
        $this->assertTrue(null !== $testimonial2->getDeletedAt());

        $testimonialManager = $this->testimonialManager->undelete($testimonial);
        $this->assertInstanceOf(TestimonialManager::class, $testimonialManager);

        $testimonial3 = $this->testimonialRepository->findOneById($testimonialId);
        $this->assertInstanceOf(Testimonial::class, $testimonial3);
        $this->assertTrue(null === $testimonial3->getDeletedAt());
    }

    public function testValidate(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $testimonial = $user->getTestimonial();

        $errors = $this->testimonialManager->validate($testimonial);
        $this->assertCount(0, $errors);

        $testimonial->setUuid('wrong');
        $errors = $this->testimonialManager->validate($testimonial);
        $this->assertCount(1, $errors);
    }
}