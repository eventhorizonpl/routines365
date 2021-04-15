<?php

declare(strict_types=1);

namespace App\Tests\Controller\Frontend;

use App\Entity\Promotion;
use App\Faker\{PromotionFaker, QuestionnaireFaker};
use App\Manager\UserManager;
use App\Tests\AbstractUiTestCase;

/**
 * @internal
 */
final class QuestionnaireControllerTest extends AbstractUiTestCase
{
    /**
     * @inject
     */
    private ?PromotionFaker $promotionFaker;
    /**
     * @inject
     */
    private ?QuestionnaireFaker $questionnaireFaker;
    /**
     * @inject
     */
    private ?UserManager $userManager;

    protected function tearDown(): void
    {
        $this->promotionFaker = null;
        $this->questionnaireFaker = null;
        $this->userManager = null
        ;

        parent::tearDown();
    }

    public function testComplete(): void
    {
        $this->purge();
        $user = $this->createAndLoginRegular();
        $promotion = $this->promotionFaker->createPromotionPersisted('REWARD10', true, null, null, null, Promotion::TYPE_SYSTEM);
        $questionnaire = $this->questionnaireFaker->createRichQuestionnairePersisted();

        $crawler = $this->client->request('GET', '/surveys/'.$questionnaire->getUuid());

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("'.$questionnaire->getTitle().'")')->count() > 0
        );

        $crawler = $this->client->submitForm('Save');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Thank you for completing this survey!")')->count() > 0
        );

        $this->assertTrue(
            $crawler->filter('div:contains("We added a small reward to your account.")')->count() > 0
        );

        $crawler = $this->client->request('GET', '/surveys/'.$questionnaire->getUuid());

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("You already completed this survey.")')->count() > 0
        );
    }
}
