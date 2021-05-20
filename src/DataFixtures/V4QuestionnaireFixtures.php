<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\{Answer, Question, User};
use App\Enum\{AnswerTypeEnum, QuestionTypeEnum, UserTypeEnum};
use App\Factory\{AnswerFactory, QuestionFactory, QuestionnaireFactory};
use App\Manager\{AnswerManager, QuestionManager, QuestionnaireManager};
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\{Fixture, FixtureGroupInterface};
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class V4QuestionnaireFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public function __construct(
        private AnswerFactory $answerFactory,
        private AnswerManager $answerManager,
        private QuestionFactory $questionFactory,
        private QuestionnaireFactory $questionnaireFactory,
        private QuestionManager $questionManager,
        private QuestionnaireManager $questionnaireManager,
        private UserRepository $userRepository
    ) {
    }

    public function getDependencies(): array
    {
        return [
            V1UserAdminFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return ['v4deployment'];
    }

    public function load(ObjectManager $manager): void
    {
        $questionnaire1 = $this->questionnaireFactory->createQuestionnaireWithRequired(
            true,
            'Product Usage'
        );

        $questionnaire1question1 = $this->questionFactory->createQuestionWithRequired(
            true,
            1,
            'How often do you use the Routines365?',
            QuestionTypeEnum::SINGLE_ANSWER
        );
        $questionnaire1question1->setQuestionnaire($questionnaire1);
        $questionnaire1question1answer1 = $this->answerFactory->createAnswerWithRequired(
            'Daily',
            true,
            1,
            AnswerTypeEnum::DEFINED
        );
        $questionnaire1question1answer1->setQuestion($questionnaire1question1);
        $questionnaire1question1answer2 = $this->answerFactory->createAnswerWithRequired(
            'A couple of times a week',
            true,
            2,
            AnswerTypeEnum::DEFINED
        );
        $questionnaire1question1answer2->setQuestion($questionnaire1question1);
        $questionnaire1question1answer3 = $this->answerFactory->createAnswerWithRequired(
            'A couple of times a month',
            true,
            3,
            AnswerTypeEnum::DEFINED
        );
        $questionnaire1question1answer3->setQuestion($questionnaire1question1);
        $questionnaire1question1answer4 = $this->answerFactory->createAnswerWithRequired(
            'I do not use it',
            true,
            4,
            AnswerTypeEnum::DEFINED
        );
        $questionnaire1question1answer4->setQuestion($questionnaire1question1);

        $questionnaire1question2 = $this->questionFactory->createQuestionWithRequired(
            true,
            2,
            'Does the Routines365 help you achieve your goals?',
            QuestionTypeEnum::SINGLE_ANSWER
        );
        $questionnaire1question2->setQuestionnaire($questionnaire1);
        $questionnaire1question2answer1 = $this->answerFactory->createAnswerWithRequired(
            'Yes',
            true,
            1,
            AnswerTypeEnum::DEFINED
        );
        $questionnaire1question2answer1->setQuestion($questionnaire1question2);
        $questionnaire1question2answer2 = $this->answerFactory->createAnswerWithRequired(
            'No',
            true,
            2,
            AnswerTypeEnum::DEFINED
        );
        $questionnaire1question2answer2->setQuestion($questionnaire1question2);

        $questionnaire1question3 = $this->questionFactory->createQuestionWithRequired(
            true,
            3,
            'What is your favorite tool or portion of the Routines365?',
            QuestionTypeEnum::SINGLE_ANSWER
        );
        $questionnaire1question3->setQuestionnaire($questionnaire1);
        $questionnaire1question3answer1 = $this->answerFactory->createAnswerWithRequired(
            'Routines',
            true,
            1,
            AnswerTypeEnum::DEFINED
        );
        $questionnaire1question3answer1->setQuestion($questionnaire1question3);
        $questionnaire1question3answer2 = $this->answerFactory->createAnswerWithRequired(
            'Reminders',
            true,
            2,
            AnswerTypeEnum::DEFINED
        );
        $questionnaire1question3answer2->setQuestion($questionnaire1question3);
        $questionnaire1question3answer3 = $this->answerFactory->createAnswerWithRequired(
            'Goals',
            true,
            3,
            AnswerTypeEnum::DEFINED
        );
        $questionnaire1question3answer3->setQuestion($questionnaire1question3);
        $questionnaire1question3answer4 = $this->answerFactory->createAnswerWithRequired(
            'Projects',
            true,
            4,
            AnswerTypeEnum::DEFINED
        );
        $questionnaire1question3answer4->setQuestion($questionnaire1question3);
        $questionnaire1question3answer5 = $this->answerFactory->createAnswerWithRequired(
            'Notes',
            true,
            5,
            AnswerTypeEnum::DEFINED
        );
        $questionnaire1question3answer5->setQuestion($questionnaire1question3);
        $questionnaire1question3answer6 = $this->answerFactory->createAnswerWithRequired(
            'Statistics',
            true,
            6,
            AnswerTypeEnum::DEFINED
        );
        $questionnaire1question3answer6->setQuestion($questionnaire1question3);
        $questionnaire1question3answer7 = $this->answerFactory->createAnswerWithRequired(
            'Own answer',
            true,
            7,
            AnswerTypeEnum::OWN
        );
        $questionnaire1question3answer7->setQuestion($questionnaire1question3);

        $questionnaire1question4 = $this->questionFactory->createQuestionWithRequired(
            true,
            4,
            'What would you improve if you could?',
            QuestionTypeEnum::SINGLE_ANSWER
        );
        $questionnaire1question4->setQuestionnaire($questionnaire1);
        $questionnaire1question4answer1 = $this->answerFactory->createAnswerWithRequired(
            'Routines',
            true,
            1,
            AnswerTypeEnum::DEFINED
        );
        $questionnaire1question4answer1->setQuestion($questionnaire1question4);
        $questionnaire1question4answer2 = $this->answerFactory->createAnswerWithRequired(
            'Reminders',
            true,
            2,
            AnswerTypeEnum::DEFINED
        );
        $questionnaire1question4answer2->setQuestion($questionnaire1question4);
        $questionnaire1question4answer3 = $this->answerFactory->createAnswerWithRequired(
            'Goals',
            true,
            3,
            AnswerTypeEnum::DEFINED
        );
        $questionnaire1question4answer3->setQuestion($questionnaire1question4);
        $questionnaire1question4answer4 = $this->answerFactory->createAnswerWithRequired(
            'Projects',
            true,
            4,
            AnswerTypeEnum::DEFINED
        );
        $questionnaire1question4answer4->setQuestion($questionnaire1question4);
        $questionnaire1question4answer5 = $this->answerFactory->createAnswerWithRequired(
            'Notes',
            true,
            5,
            AnswerTypeEnum::DEFINED
        );
        $questionnaire1question4answer5->setQuestion($questionnaire1question4);
        $questionnaire1question4answer6 = $this->answerFactory->createAnswerWithRequired(
            'Statistics',
            true,
            6,
            AnswerTypeEnum::DEFINED
        );
        $questionnaire1question4answer6->setQuestion($questionnaire1question4);
        $questionnaire1question4answer7 = $this->answerFactory->createAnswerWithRequired(
            'Own answer',
            true,
            7,
            AnswerTypeEnum::OWN
        );
        $questionnaire1question4answer7->setQuestion($questionnaire1question4);

        $user = $this->userRepository->findOneBy([
            'type' => UserTypeEnum::STAFF,
        ], [
            'id' => 'ASC',
        ]);

        if (null !== $user) {
            $this->questionnaireManager->save($questionnaire1, (string) $user);
            $this->questionManager->save($questionnaire1question1, (string) $user);
            $this->answerManager->save($questionnaire1question1answer1, (string) $user);
            $this->answerManager->save($questionnaire1question1answer2, (string) $user);
            $this->answerManager->save($questionnaire1question1answer3, (string) $user);
            $this->answerManager->save($questionnaire1question1answer4, (string) $user);
            $this->questionManager->save($questionnaire1question2, (string) $user);
            $this->answerManager->save($questionnaire1question2answer1, (string) $user);
            $this->answerManager->save($questionnaire1question2answer2, (string) $user);
            $this->questionManager->save($questionnaire1question3, (string) $user);
            $this->answerManager->save($questionnaire1question3answer1, (string) $user);
            $this->answerManager->save($questionnaire1question3answer2, (string) $user);
            $this->answerManager->save($questionnaire1question3answer3, (string) $user);
            $this->answerManager->save($questionnaire1question3answer4, (string) $user);
            $this->answerManager->save($questionnaire1question3answer5, (string) $user);
            $this->answerManager->save($questionnaire1question3answer6, (string) $user);
            $this->answerManager->save($questionnaire1question3answer7, (string) $user);
            $this->questionManager->save($questionnaire1question4, (string) $user);
            $this->answerManager->save($questionnaire1question4answer1, (string) $user);
            $this->answerManager->save($questionnaire1question4answer2, (string) $user);
            $this->answerManager->save($questionnaire1question4answer3, (string) $user);
            $this->answerManager->save($questionnaire1question4answer4, (string) $user);
            $this->answerManager->save($questionnaire1question4answer5, (string) $user);
            $this->answerManager->save($questionnaire1question4answer6, (string) $user);
            $this->answerManager->save($questionnaire1question4answer7, (string) $user);
        }
    }
}
