<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Kpi;
use App\Factory\KpiFactory;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use Faker\Factory;
use Faker\Generator;

/**
 * @internal
 * @coversNothing
 */
final class KpiFactoryTest extends AbstractTestCase
{
    private ?Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    protected function tearDown(): void
    {
        $this->faker = null;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $kpiFactory = new KpiFactory();

        $this->assertInstanceOf(KpiFactory::class, $kpiFactory);
    }

    public function testCreateKpi(): void
    {
        $kpiFactory = new KpiFactory();
        $kpi = $kpiFactory->createKpi();
        $this->assertInstanceOf(Kpi::class, $kpi);
    }

    public function testCreateKpiWithRequired(): void
    {
        $accountCounter = $this->faker->randomNumber;
        $accountOperationCounter = $this->faker->randomNumber;
        $achievementCounter = $this->faker->randomNumber;
        $answerCounter = $this->faker->randomNumber;
        $completedRoutineCounter = $this->faker->randomNumber;
        $contactCounter = $this->faker->randomNumber;
        $date = new DateTimeImmutable();
        $goalCounter = $this->faker->randomNumber;
        $noteCounter = $this->faker->randomNumber;
        $profileCounter = $this->faker->randomNumber;
        $projectCounter = $this->faker->randomNumber;
        $promotionCounter = $this->faker->randomNumber;
        $questionCounter = $this->faker->randomNumber;
        $questionnaireCounter = $this->faker->randomNumber;
        $quoteCounter = $this->faker->randomNumber;
        $reminderCounter = $this->faker->randomNumber;
        $reminderMessageCounter = $this->faker->randomNumber;
        $retentionCounter = $this->faker->randomNumber;
        $rewardCounter = $this->faker->randomNumber;
        $routineCounter = $this->faker->randomNumber;
        $savedEmailCounter = $this->faker->randomNumber;
        $sentReminderCounter = $this->faker->randomNumber;
        $userCounter = $this->faker->randomNumber;
        $userKpiCounter = $this->faker->randomNumber;
        $userKytCounter = $this->faker->randomNumber;
        $userQuestionnaireCounter = $this->faker->randomNumber;
        $userQuestionnaireAnswerCounter = $this->faker->randomNumber;
        $kpiFactory = new KpiFactory();
        $kpi = $kpiFactory->createKpiWithRequired(
            $accountCounter,
            $accountOperationCounter,
            $achievementCounter,
            $answerCounter,
            $completedRoutineCounter,
            $contactCounter,
            $date,
            $goalCounter,
            $noteCounter,
            $profileCounter,
            $projectCounter,
            $promotionCounter,
            $questionCounter,
            $questionnaireCounter,
            $quoteCounter,
            $reminderCounter,
            $reminderMessageCounter,
            $retentionCounter,
            $rewardCounter,
            $routineCounter,
            $savedEmailCounter,
            $sentReminderCounter,
            $userCounter,
            $userKpiCounter,
            $userKytCounter,
            $userQuestionnaireCounter,
            $userQuestionnaireAnswerCounter
        );
        $this->assertInstanceOf(Kpi::class, $kpi);
        $this->assertSame($accountCounter, $kpi->getAccountCounter());
        $this->assertSame($accountOperationCounter, $kpi->getAccountOperationCounter());
        $this->assertSame($achievementCounter, $kpi->getAchievementCounter());
        $this->assertSame($answerCounter, $kpi->getAnswerCounter());
        $this->assertSame($completedRoutineCounter, $kpi->getCompletedRoutineCounter());
        $this->assertSame($contactCounter, $kpi->getContactCounter());
        $this->assertSame($date, $kpi->getDate());
        $this->assertSame($goalCounter, $kpi->getGoalCounter());
        $this->assertSame($noteCounter, $kpi->getNoteCounter());
        $this->assertSame($profileCounter, $kpi->getProfileCounter());
        $this->assertSame($projectCounter, $kpi->getProjectCounter());
        $this->assertSame($promotionCounter, $kpi->getPromotionCounter());
        $this->assertSame($questionCounter, $kpi->getQuestionCounter());
        $this->assertSame($questionnaireCounter, $kpi->getQuestionnaireCounter());
        $this->assertSame($quoteCounter, $kpi->getQuoteCounter());
        $this->assertSame($reminderCounter, $kpi->getReminderCounter());
        $this->assertSame($reminderMessageCounter, $kpi->getReminderMessageCounter());
        $this->assertSame($retentionCounter, $kpi->getRetentionCounter());
        $this->assertSame($rewardCounter, $kpi->getRewardCounter());
        $this->assertSame($routineCounter, $kpi->getRoutineCounter());
        $this->assertSame($savedEmailCounter, $kpi->getSavedEmailCounter());
        $this->assertSame($sentReminderCounter, $kpi->getSentReminderCounter());
        $this->assertSame($userCounter, $kpi->getUserCounter());
        $this->assertSame($userKpiCounter, $kpi->getUserKpiCounter());
        $this->assertSame($userKytCounter, $kpi->getUserKytCounter());
        $this->assertSame($userQuestionnaireCounter, $kpi->getUserQuestionnaireCounter());
        $this->assertSame($userQuestionnaireAnswerCounter, $kpi->getUserQuestionnaireAnswerCounter());
    }
}
