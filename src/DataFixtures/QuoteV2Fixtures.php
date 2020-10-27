<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\QuoteFactory;
use App\Manager\QuoteManager;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class QuoteV2Fixtures extends Fixture implements FixtureGroupInterface
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

    public static function getGroups(): array
    {
        return ['v2deployment'];
    }

    public function load(ObjectManager $manager): void
    {
        $dataset = [
            [
                'author' => 'Confucius',
                'content' => 'The will to win, the desire to succeed, the urge to reach your full potential…these are the keys that will unlock the door to personal excellence.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'Everything has beauty, but not everyone sees it.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'When it is obvious that the goals cannot be reached, don’t adjust the goals, adjust the action steps.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'Choose a job you love, and you will never have to work a day in your life.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'By three methods we may learn wisdom: First, by reflection, which is noblest; second, by imitation, which is easiest; and third by experience, which is the bitterest.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'Success depends upon previous preparation, and without such preparation there is sure to be failure.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'If I am walking with two other men, each of them will serve as my teacher. I will pick out the good points of the one and imitate them, and the bad points of the other and correct them in myself.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'To know what you know and what you do not know, that is true knowledge.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'It does not matter how slowly you go as long as you do not stop.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'Wisdom, compassion, and courage are the three universally recognized moral qualities of men.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'You cannot open a book without learning something.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'Better a diamond with a flaw than a pebble without.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'If you think in terms of a year, plant a seed; if in terms of ten years, plant trees; if in terms of 100 years, teach the people.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'The expectations of life depend upon diligence; the mechanic that would perfect his work must first sharpen his tools.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'A superior man is modest in his speech, but exceeds in his actions.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'Humility is the solid foundation of all virtues.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'The more man meditates upon good thoughts, the better will be his world and the world at large.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'Study the past, if you would define the future.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'I want you to be everything that’s you, deep at the center of your being.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'Instead of being concerned that you have no office, be concerned to think how you may fit yourself for office. Instead of being concerned that you are not known, seek to be worthy of being known.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'The superior man is distressed by the limitations of his ability; he is not distressed by the fact that men do not recognize the ability that he has.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'He who speaks without modesty will find it difficult to make his words good.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'When you are laboring for others let it be with the same zeal as if it were for yourself.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'Do not impose on others what you yourself do not desire.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'To be wronged is nothing unless you continue to remember it.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'I will not be concerned at other men’s not knowing me; I will be concerned at my own want of ability.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'The faults of a superior person are like the sun and moon. They have their faults, and everyone sees them; they change and everyone looks up to them.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'When we see persons of worth, we should think of equaling them; when we see persons of a contrary character, we should turn inwards and examine ourselves.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'Ability will never catch up with the demand for it.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'Virtue is not left to stand alone. He who practices it will have neighbors.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'Go before the people with your example, and be laborious in their affairs.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'Life is really simple, but we insist on making it complicated.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'A common man marvels at uncommon things. A wise man marvels at the commonplace.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'Faced with what is right, to leave it undone shows a lack of courage.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'The gem cannot be polished without friction nor man without trials.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'Silence is a true friend who never betrays.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'Only the wisest and stupidest of men never change.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'Your life is what your thoughts make it.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'Looking at small advantages prevents great affairs from being accomplished.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'The firm, the enduring, the simple, and the modest are near to virtue.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'Forget injuries, never forget kindness.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'Men’s natures are alike, it is their habits that carry them far apart.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'They must often change who would be constant in happiness or wisdom.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'I am not one who was born in the possession of knowledge; I am one who is fond of antiquity, and earnest in seeking it there.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'When anger rises, think of the consequences.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'All good things are difficult to achieve, and all bad things are very easy to get.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'A fool despises good counsel, but a wise man takes it to heart.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'Worry not that no one knows you; seek to be worth knowing.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'When you have faults, do not fear to abandon them.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'Be strict with yourself but least reproachful of others and complaint is kept afar.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'Imagination is more important than knowledge.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'Respect yourself and others will respect you.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'He who knows all the answers has not been asked all the questions.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'Ignorance is the night of the mind, but a night without moon and star.',
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
            $this->quoteManager->bulkSave($quotes, $user);
        }
    }
}
