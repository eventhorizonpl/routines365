<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\UserQuestionnaire;
use Symfony\Component\Uid\Uuid;

class UserQuestionnaireFactory
{
    public function createUserQuestionnaire(): UserQuestionnaire
    {
        $userQuestionnaire = new UserQuestionnaire();
        $userQuestionnaire->setUuid((string) Uuid::v4());

        return $userQuestionnaire;
    }

    public function createUserQuestionnaireWithRequired(
        bool $isRewarded
    ): UserQuestionnaire {
        $userQuestionnaire = $this->createUserQuestionnaire();

        $userQuestionnaire->setIsRewarded($isRewarded);

        return $userQuestionnaire;
    }
}
