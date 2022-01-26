<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\UserKpi;
use App\Enum\UserKpiTypeEnum;
use App\Factory\UserKpiFactory;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use Faker\{Factory, Generator};

/**
 * @internal
 */
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
        $this->faker = null;

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
        $accountOperationCounter = $this->faker->randomNumber();
        $awardedRewardCounter = $this->faker->randomNumber();
        $completedGoalCounter = $this->faker->randomNumber();
        $completedProjectCounter = $this->faker->randomNumber();
        $completedRoutineCounter = $this->faker->randomNumber();
        $contactCounter = $this->faker->randomNumber();
        $date = new DateTimeImmutable();
        $goalCounter = $this->faker->randomNumber();
        $noteCounter = $this->faker->randomNumber();
        $projectCounter = $this->faker->randomNumber();
        $reminderCounter = $this->faker->randomNumber();
        $rewardCounter = $this->faker->randomNumber();
        $routineCounter = $this->faker->randomNumber();
        $savedEmailCounter = $this->faker->randomNumber();
        $type = UserKpiTypeEnum::ANNUALLY;
        $userQuestionnaireCounter = $this->faker->randomNumber();
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
        $this->assertSame($accountOperationCounter, $userKpi->getAccountOperationCounter());
        $this->assertSame($awardedRewardCounter, $userKpi->getAwardedRewardCounter());
        $this->assertSame($completedGoalCounter, $userKpi->getCompletedGoalCounter());
        $this->assertSame($completedProjectCounter, $userKpi->getCompletedProjectCounter());
        $this->assertSame($completedRoutineCounter, $userKpi->getCompletedRoutineCounter());
        $this->assertSame($contactCounter, $userKpi->getContactCounter());
        $this->assertSame($date, $userKpi->getDate());
        $this->assertSame($goalCounter, $userKpi->getGoalCounter());
        $this->assertSame($noteCounter, $userKpi->getNoteCounter());
        $this->assertSame($projectCounter, $userKpi->getProjectCounter());
        $this->assertSame($reminderCounter, $userKpi->getReminderCounter());
        $this->assertSame($rewardCounter, $userKpi->getRewardCounter());
        $this->assertSame($routineCounter, $userKpi->getRoutineCounter());
        $this->assertSame($savedEmailCounter, $userKpi->getSavedEmailCounter());
        $this->assertSame($type, $userKpi->getType());
        $this->assertSame($userQuestionnaireCounter, $userKpi->getUserQuestionnaireCounter());
    }
}
