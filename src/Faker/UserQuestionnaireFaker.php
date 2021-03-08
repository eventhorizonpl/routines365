<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\Questionnaire;
use App\Entity\User;
use App\Entity\UserQuestionnaire;
use App\Factory\UserQuestionnaireFactory;
use App\Manager\UserQuestionnaireManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Uid\Uuid;

class UserQuestionnaireFaker
{
    private Generator $faker;

    public function __construct(
        private UserQuestionnaireFactory $userQuestionnaireFactory,
        private UserQuestionnaireManager $userQuestionnaireManager
    ) {
        $this->faker = Factory::create();
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
        User $user,
        Questionnaire $questionnaire,
        ?bool $isRewarded = null
    ): UserQuestionnaire {
        $userQuestionnaire = $this->createUserQuestionnaire(
            $isRewarded
        );
        $userQuestionnaire
            ->setQuestionnaire($questionnaire)
            ->setUser($user);
        $this->userQuestionnaireManager->save($userQuestionnaire, (string) Uuid::v4());

        return $userQuestionnaire;
    }
}
