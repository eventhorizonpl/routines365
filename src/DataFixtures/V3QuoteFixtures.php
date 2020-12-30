<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\QuoteFactory;
use App\Manager\QuoteManager;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class V3QuoteFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    private QuoteFactory $quoteFactory;
    private QuoteManager $quoteManager;
    private UserRepository $userRepository;

    public function __construct(
        QuoteFactory $quoteFactory,
        QuoteManager $quoteManager,
        UserRepository $userRepository
    ) {
        $this->quoteFactory = $quoteFactory;
        $this->quoteManager = $quoteManager;
        $this->userRepository = $userRepository;
    }

    public function getDependencies(): array
    {
        return [
            V1UserAdminFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return ['v3deployment'];
    }

    public function load(ObjectManager $manager): void
    {
        $dataset = [
            [
                'author' => 'Portuguese proverb',
                'content' => 'There are no short cuts to any place worth going.',
            ],
            [
                'author' => 'Portuguese proverb',
                'content' => 'Always bear in mind that your own resolution to succeed is more important than any other.',
            ],
            [
                'author' => 'Portuguese proverb',
                'content' => 'You miss 100% of the shots you don’t take.',
            ],
            [
                'author' => 'Portuguese proverb',
                'content' => 'The greatest danger for most of us is not that our aim is too high and we miss it, but that is it too low and we reach it.',
            ],
            [
                'author' => 'Portuguese proverb',
                'content' => 'You can never cross the ocean until you have the courage to lose sight of the shore.',
            ],
            [
                'author' => 'Portuguese proverb',
                'content' => 'Whatever the mind of man can conceive and believe, it can achieve.',
            ],
            [
                'author' => 'Portuguese proverb',
                'content' => 'An ounce of patience is worth a pound of brains.',
            ],
            [
                'author' => 'Portuguese proverb',
                'content' => 'Experience is the mother of wisdom.',
            ],
            [
                'author' => 'Portuguese proverb',
                'content' => 'Don’t leave for tomorrow what you can do today.',
            ],
            [
                'author' => 'Portuguese proverb',
                'content' => 'Those who do not risk, do not benefit.',
            ],
            [
                'author' => 'Portuguese proverb',
                'content' => 'Nothing ventured, nothing gained.',
            ],
            [
                'author' => 'Portuguese proverb',
                'content' => 'Passed waters can’t move the mills.',
            ],
            [
                'author' => 'Portuguese proverb',
                'content' => 'Necessity makes the frog jump.',
            ],
            [
                'author' => 'Portuguese proverb',
                'content' => 'You reap what you sow.',
            ],
        ];

        $quotes = [];
        foreach ($dataset as $data) {
            $quotes[] = $this->quoteFactory->createQuoteWithRequired(
                $data['author'],
                $data['content'],
                true
            );
        }

        $user = $this->userRepository->findOneBy([
            'type' => User::TYPE_STAFF,
        ], [
            'id' => 'ASC',
        ]);

        if (null !== $user) {
            $this->quoteManager->bulkSave($quotes, (string) $user);
        }
    }
}
