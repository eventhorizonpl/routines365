<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\UserKpi;
use App\Factory\UserKpiFactory;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use Faker\Factory;
use Faker\Generator;

final class UserKpiFactoryTest extends AbstractTestCase
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
        $userKpiFactory = new UserKpiFactory();

        $this->assertInstanceOf(UserKpiFactory::class, $userKpiFactory);
    }

    public function testCreateUserKpi(): void
    {
        $userKpiFactory = new UserKpiFactory();
        $userKpi = $userKpiFactory->createUserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi);
    }

    public function testCreateUserKpiWithRequired(): void
    {
        $accountOperationCounter = $this->faker->randomNumber;
        $awardedRewardCounter = $this->faker->randomNumber;
        $completedGoalCounter = $this->faker->randomNumber;
        $completedProjectCounter = $this->faker->randomNumber;
        $completedRoutineCounter = $this->faker->randomNumber;
        $contactCounter = $this->faker->randomNumber;
        $date = new DateTimeImmutable();
        $goalCounter = $this->faker->randomNumber;
        $noteCounter = $this->faker->randomNumber;
        $projectCounter = $this->faker->randomNumber;
        $reminderCounter = $this->faker->randomNumber;
        $rewardCounter = $this->faker->randomNumber;
        $routineCounter = $this->faker->randomNumber;
        $savedEmailCounter = $this->faker->randomNumber;
        $type = $this->faker->randomElement(
            UserKpi::getTypeFormChoices()
        );
        $userQuestionnaireCounter = $this->faker->randomNumber;
        $userKpiFactory = new UserKpiFactory();
        $userKpi = $userKpiFactory->createUserKpiWithRequired(
            $accountOperationCounter,
            $awardedRewardCounter,
            $completedGoalCounter,
            $completedProjectCounter,
            $completedRoutineCounter,
            $contactCounter,
            $date,
            $goalCounter,
            $noteCounter,
            $projectCounter,
            $reminderCounter,
            $rewardCounter,
            $routineCounter,
            $savedEmailCounter,
            $type,
            $userQuestionnaireCounter
        );
        $this->assertInstanceOf(UserKpi::class, $userKpi);
        $this->assertEquals($accountOperationCounter, $userKpi->getAccountOperationCounter());
        $this->assertEquals($awardedRewardCounter, $userKpi->getAwardedRewardCounter());
        $this->assertEquals($completedGoalCounter, $userKpi->getCompletedGoalCounter());
        $this->assertEquals($completedProjectCounter, $userKpi->getCompletedProjectCounter());
        $this->assertEquals($completedRoutineCounter, $userKpi->getCompletedRoutineCounter());
        $this->assertEquals($contactCounter, $userKpi->getContactCounter());
        $this->assertEquals($date, $userKpi->getDate());
        $this->assertEquals($goalCounter, $userKpi->getGoalCounter());
        $this->assertEquals($noteCounter, $userKpi->getNoteCounter());
        $this->assertEquals($projectCounter, $userKpi->getProjectCounter());
        $this->assertEquals($reminderCounter, $userKpi->getReminderCounter());
        $this->assertEquals($rewardCounter, $userKpi->getRewardCounter());
        $this->assertEquals($routineCounter, $userKpi->getRoutineCounter());
        $this->assertEquals($savedEmailCounter, $userKpi->getSavedEmailCounter());
        $this->assertEquals($type, $userKpi->getType());
        $this->assertEquals($userQuestionnaireCounter, $userKpi->getUserQuestionnaireCounter());
    }
}
