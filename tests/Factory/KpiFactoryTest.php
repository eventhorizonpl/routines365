<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Kpi;
use App\Factory\KpiFactory;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use Faker\Factory;
use Faker\Generator;

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
        unset($this->faker);

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
        $this->assertEquals($accountCounter, $kpi->getAccountCounter());
        $this->assertEquals($accountOperationCounter, $kpi->getAccountOperationCounter());
        $this->assertEquals($achievementCounter, $kpi->getAchievementCounter());
        $this->assertEquals($answerCounter, $kpi->getAnswerCounter());
        $this->assertEquals($completedRoutineCounter, $kpi->getCompletedRoutineCounter());
        $this->assertEquals($contactCounter, $kpi->getContactCounter());
        $this->assertEquals($date, $kpi->getDate());
        $this->assertEquals($goalCounter, $kpi->getGoalCounter());
        $this->assertEquals($noteCounter, $kpi->getNoteCounter());
        $this->assertEquals($profileCounter, $kpi->getProfileCounter());
        $this->assertEquals($projectCounter, $kpi->getProjectCounter());
        $this->assertEquals($promotionCounter, $kpi->getPromotionCounter());
        $this->assertEquals($questionCounter, $kpi->getQuestionCounter());
        $this->assertEquals($questionnaireCounter, $kpi->getQuestionnaireCounter());
        $this->assertEquals($quoteCounter, $kpi->getQuoteCounter());
        $this->assertEquals($reminderCounter, $kpi->getReminderCounter());
        $this->assertEquals($reminderMessageCounter, $kpi->getReminderMessageCounter());
        $this->assertEquals($retentionCounter, $kpi->getRetentionCounter());
        $this->assertEquals($rewardCounter, $kpi->getRewardCounter());
        $this->assertEquals($routineCounter, $kpi->getRoutineCounter());
        $this->assertEquals($savedEmailCounter, $kpi->getSavedEmailCounter());
        $this->assertEquals($sentReminderCounter, $kpi->getSentReminderCounter());
        $this->assertEquals($userCounter, $kpi->getUserCounter());
        $this->assertEquals($userKpiCounter, $kpi->getUserKpiCounter());
        $this->assertEquals($userKytCounter, $kpi->getUserKytCounter());
        $this->assertEquals($userQuestionnaireCounter, $kpi->getUserQuestionnaireCounter());
        $this->assertEquals($userQuestionnaireAnswerCounter, $kpi->getUserQuestionnaireAnswerCounter());
    }
}
