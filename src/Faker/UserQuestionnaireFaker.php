<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\UserQuestionnaire;
use App\Factory\UserQuestionnaireFactory;
use App\Manager\UserQuestionnaireManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Uid\Uuid;

class UserQuestionnaireFaker
{
    private Generator $faker;
    private UserQuestionnaireFactory $userQuestionnaireFactory;
    private UserQuestionnaireManager $userQuestionnaireManager;

    public function __construct(
        UserQuestionnaireFactory $userQuestionnaireFactory,
        UserQuestionnaireManager $userQuestionnaireManager
    ) {
        $this->faker = Factory::create();
        $this->userQuestionnaireFactory = $userQuestionnaireFactory;
        $this->userQuestionnaireManager = $userQuestionnaireManager;
    }

    public function createUserQuestionnaire(
        ?bool $isRewarded = null
    ): UserQuestionnaire {
        if (null === $isRewarded) {
            $isRewarded = (bool) $this->faker->boolean;
        }

        $userQuestionnaire = $this->userQuestionnaireFactory->createUserQuestionnaireWithRequired(
            $isRewarded
        );

        return $userQuestionnaire;
    }

    public function createUserQuestionnairePersisted(
        ?bool $isRewarded = null
    ): UserQuestionnaire {
        $userQuestionnaire = $this->createUserQuestionnaire(
            $isRewarded
        );
        $this->userQuestionnaireManager->save($userQuestionnaire, (string) Uuid::v4());

        return $userQuestionnaire;
    }
}
