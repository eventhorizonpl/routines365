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

class V2QuoteFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public function __construct(
        private QuoteFactory $quoteFactory,
        private QuoteManager $quoteManager,
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
            [
                'author' => 'Chinese Proverb',
                'content' => 'A crisis is an opportunity riding the dangerous wind.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'It’s better to be without a book than to believe a book entirely.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'A little impatience will spoil great plans.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'A journey of a thousand miles begins with a single step.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'A smile will gain you ten more years of life.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'A bird does not sing because it has an answer. It sings because it has a song.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'A book holds a house of gold.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'Talk does not cook rice.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'A man who cannot tolerate small misfortunes can never accomplish great things.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'Experience is a comb which nature gives us when we are bald.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'Be not afraid of growing slowly, be afraid only of standing still.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'A fall into a ditch makes you wiser.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'He who asks is a fool for five minutes, but he who does not ask remains a fool forever.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'An inch of time is an inch of gold but you can’t buy that inch of time with an inch of gold.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'A closed mind is like a closed book; just a block of wood.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'Better to light a candle than to curse the darkness.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'A needle is not sharp at both ends.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'Habits are cobwebs at first; cables at last.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'The best time to plant a tree was 20 years ago. The second best time is today.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'Patience is a bitter plant, but its fruit is sweet.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'Two good talkers are not worth one good listener.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'A hundred no’s are less agonizing than one insincere yes.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'He who cheats the earth will be cheated by the earth.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'Only one who can swallow an insult is a man.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'One beam, no matter how big, cannot support an entire house on its own.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'Better the cottage where one is merry than the palace where one weeps.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'Distant water does not put out a nearby fire.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'He who thinks too much about every step he takes will always stay on one leg.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'All things change, and we change with them.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'If you want to find out about the road ahead, then ask about it from those coming back.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'Genius can be recognized by its childish simplicity.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'There are two kinds of perfect people: those who are dead, and those who have not been born yet.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'Learning is a weightless treasure you can always carry easily.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'Small men think they are small; great men never know they are great.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'Do everything at the right time, and one day will seem like three.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'Solve one problem, and you keep a hundred others away.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'It is easy to open a store - the hard part is keeping it open.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'To be totally at leisure for one day is to be immortal for one day.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'Fool me once, shame on you; fool me twice, shame on me.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'Teachers open the door. You enter by yourself.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'Ripe fruit falls by itself - but it doesn’t fall in your mouth.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'If you are patient in one moment of anger, you will escape a hundred days of sorrow.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'Before preparing to improve the world, first look around your own home three times.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'I was angered, for I had no shoes. Then I met a man who had no feet.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'Men trip not on mountains they trip on molehills.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'It is not the knowing that is difficult, but the doing.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'A wise man makes his own decisions, but an ignorant man mindlessly follows the crowd.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'The people who talk the best are not the only ones who can tell you the most interesting things.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'Do not believe that you will reach your destination without leaving the shore.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'A clever person turns great troubles into little ones, and little ones into none at all.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'The person who is his own master cannot tolerate another boss.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'Guessing is cheap, but guessing wrong can be expensive.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'Learning is a treasure that will follow its owner everywhere.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'No matter how tall the mountain is, it cannot block the sun.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'Tenacity and adversity are old foes.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'Think about your own faults during the first half of the night, and the faults of others during the second half.',
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
