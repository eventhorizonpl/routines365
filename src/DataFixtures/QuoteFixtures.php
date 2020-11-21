<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\QuoteFactory;
use App\Manager\QuoteManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class QuoteFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    private QuoteFactory $quoteFactory;
    private QuoteManager $quoteManager;

    public function __construct(
        QuoteFactory $quoteFactory,
        QuoteManager $quoteManager
    ) {
        $this->quoteFactory = $quoteFactory;
        $this->quoteManager = $quoteManager;
    }

    public function getDependencies(): array
    {
        return [
            UserAdminFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return ['v1deployment'];
    }

    public function load(ObjectManager $manager): void
    {
        $dataset = [
            [
                'author' => 'Walt Disney',
                'content' => 'All our dreams can come true, if we have the courage to pursue them.',
            ],
            [
                'author' => 'Mark Twain',
                'content' => 'The secret of getting ahead is getting started.',
            ],
            [
                'author' => 'Michael Jordan',
                'content' => 'I’ve missed more than 9,000 shots in my career. I’ve lost almost 300 games. 26 times I’ve been trusted to take the game winning shot and missed. I’ve failed over and over and over again in my life and that is why I succeed.',
            ],
            [
                'author' => 'Mary Kay Ash',
                'content' => 'Don’t limit yourself. Many people limit themselves to what they think they can do. You can go as far as your mind lets you. What you believe, remember, you can achieve.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'The best time to plant a tree was 20 years ago. The second best time is now.',
            ],
            [
                'author' => 'Andy Grove',
                'content' => 'Only the paranoid survive.',
            ],
            [
                'author' => 'Babe Ruth',
                'content' => 'It’s hard to beat a person who never gives up.',
            ],
            [
                'author' => 'Leah Busque',
                'content' => 'I wake up every morning and think to myself, ‘how far can I push this company in the next 24 hours.’',
            ],
            [
                'author' => 'Michele Ruiz',
                'content' => 'If people are doubting how far you can go, go so far that you can’t hear them anymore.',
            ],
            [
                'author' => 'Arianna Huffington',
                'content' => 'We need to accept that we won’t always make the right decisions, that we’ll screw up royally sometimes – understanding that failure is not the opposite of success, it’s part of success.',
            ],
            [
                'author' => 'Joss Whedon',
                'content' => 'Write it. Shoot it. Publish it. Crochet it, sauté it, whatever. MAKE.',
            ],
            [
                'author' => 'William W. Purkey',
                'content' => 'You’ve gotta dance like there’s nobody watching, love like you’ll never be hurt, sing like there’s nobody listening, and live like it’s heaven on earth.',
            ],
            [
                'author' => 'Neil Gaiman',
                'content' => 'Fairy tales are more than true: not because they tell us that dragons exist, but because they tell us that dragons can be beaten.',
            ],
            [
                'author' => 'Pablo Picasso',
                'content' => 'Everything you can imagine is real.',
            ],
            [
                'author' => 'Helen Keller',
                'content' => 'When one door of happiness closes, another opens; but often we look so long at the closed door that we do not see the one which has been opened for us.',
            ],
            [
                'author' => 'Eleanor Roosevelt',
                'content' => 'Do one thing every day that scares you.',
            ],
            [
                'author' => 'Lewis Carroll',
                'content' => 'It’s no use going back to yesterday, because I was a different person then.',
            ],
            [
                'author' => 'Socrates',
                'content' => 'Smart people learn from everything and everyone, average people from their experiences, stupid people already have all the answers.',
            ],
            [
                'author' => 'Eleanor Roosevelt',
                'content' => 'Do what you feel in your heart to be right – for you’ll be criticized anyway.',
            ],
            [
                'author' => 'Dalai Lama XIV',
                'content' => 'Happiness is not something ready made. It comes from your own actions.',
            ],
            [
                'author' => 'Abraham Lincoln',
                'content' => 'Whatever you are, be a good one.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'The same boiling water that softens the potato hardens the egg. It’s what you’re made of. Not the circumstances.',
            ],
            [
                'author' => 'Catherine Pulsifier',
                'content' => 'If we have the attitude that it’s going to be a great day it usually is.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'You can either experience the pain of discipline or the pain of regret. The choice is yours.',
            ],
            [
                'author' => 'Paulo Coelho',
                'content' => 'Impossible is just an opinion.',
            ],
            [
                'author' => 'Isabelle Lafleche',
                'content' => 'Your passion is waiting for your courage to catch up.',
            ],
            [
                'author' => 'Johann Wolfgang Von Goethe',
                'content' => 'Magic is believing in yourself. If you can make that happen, you can make anything happen.',
            ],
            [
                'author' => 'Elon Musk',
                'content' => 'If something is important enough, even if the odds are stacked against you, you should still do it.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Hold the vision, trust the process.',
            ],
            [
                'author' => 'John D. Rockefeller',
                'content' => 'Don’t be afraid to give up the good to go for the great.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'People who wonder if the glass is half empty or full miss the point. The glass is refillable.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Just another Magic Monday.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'One day or day one. You decide.',
            ],
            [
                'author' => 'Heather Stillufsen',
                'content' => 'It’s Monday… time to motivate and make dreams and goals happen. Let’s go!',
            ],
            [
                'author' => 'Marcus Zusak',
                'content' => 'It was a Monday and they walked on a tightrope to the sun.',
            ],
            [
                'author' => 'Kurt Vonnegut',
                'content' => 'Goodbye blue Monday.',
            ],
            [
                'author' => 'Julio-Alexi Genao',
                'content' => 'So. Monday. We meet again. We will never be friends—but maybe we can move past our mutual enmity toward a more-positive partnership.',
            ],
            [
                'author' => 'Ella Woodword',
                'content' => 'When life gives you Monday, dip it in glitter and sparkle all day.',
            ],
            [
                'author' => 'Jaymin Shah',
                'content' => 'No one is to blame for your future situation but yourself. If you want to be successful, then become “Successful.”',
            ],
            [
                'author' => 'Abraham Lincoln',
                'content' => 'Things may come to those who wait, but only the things left by those who hustle.',
            ],
            [
                'author' => 'Thomas Edison',
                'content' => 'Everything comes to him who hustles while he waits.',
            ],
            [
                'author' => 'K’wan',
                'content' => 'Every sucessful person in the world is a hustler one way or another. We all hustle to get where we need to be. Only a fool would sit around and wait on another man to feed him.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Invest in your dreams. Grind now. Shine later.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Hustlers don’t sleep, they nap.',
            ],
            [
                'author' => 'Ross Simmonds',
                'content' => 'Greatness only comes before hustle in the dictionary.',
            ],
            [
                'author' => 'Gary Vaynerchuk',
                'content' => 'Without hustle, talent will only carry you so far.',
            ],
            [
                'author' => 'Mark Cuban',
                'content' => 'Work like there is someone working twenty four hours a day to take it away from you.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Hustle in silence and let your success make the noise.',
            ],
            [
                'author' => 'Aristotle',
                'content' => 'We are what we repeatedly do. Excellence, then, is not an act, but a habit.',
            ],
            [
                'author' => 'Sheryl Sandberg',
                'content' => 'If you’re offered a seat on a rocket ship, don’t ask what seat! Just get on.',
            ],
            [
                'author' => 'Marissa Mayer',
                'content' => 'I always did something I was a little not ready to do. I think that’s how you grow. When there’s that moment of ‘Wow, I’m not really sure I can do this,’ and you push through those moments, that’s when you have a breakthrough.',
            ],
            [
                'author' => 'Vincent Van Gogh',
                'content' => 'If you hear a voice within you say ‘you cannot paint,’ then by all means paint and that voice will be silenced.',
            ],
            [
                'author' => 'Anne Frank',
                'content' => 'How wonderful it is that nobody need wait a single moment before starting to improve the world.',
            ],
            [
                'author' => 'Michael Jordan',
                'content' => 'Some people want it to happen, some wish it would happen, others make it happen.',
            ],
            [
                'author' => 'Vincent Van Gogh',
                'content' => 'Great things are done by a series of small things brought together.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'If you hire people just because they can do a job, they’ll work for your money. But if you hire people who believe what you believe, they’ll work for you with blood and sweat and tears.',
            ],
            [
                'author' => 'A.C. Benson',
                'content' => 'Very often, a change of self is needed more than a change of scene.',
            ],
            [
                'author' => 'Stanley McChrystal',
                'content' => 'Leaders can let you fail and yet not let you be a failure.',
            ],
            [
                'author' => 'Lou Holtz',
                'content' => 'It’s not the load that breaks you down, it’s the way you carry it.',
            ],
            [
                'author' => 'Aly Raisman',
                'content' => 'The hard days are what make you stronger.',
            ],
            [
                'author' => 'Wayne Dyer',
                'content' => 'If you believe it’ll work out, you’ll see opportunities. If you don’t believe it’ll work out, you’ll see obstacles.',
            ],
            [
                'author' => 'Theodore Roosevelt',
                'content' => 'Keep your eyes on the stars, and your feet on the ground.',
            ],
            [
                'author' => 'Shonda Rhimes',
                'content' => 'You can waste your lives drawing lines. Or you can live your life crossing them.',
            ],
            [
                'author' => 'George Lorimer',
                'content' => 'You’ve got to get up every morning with determination if you’re going to go to bed with satisfaction.',
            ],
            [
                'author' => 'Michelle Obama',
                'content' => 'I now tried a new hypothesis: It was possible that I was more in charge of my happiness than I was allowing myself to be.',
            ],
            [
                'author' => 'Mahatma Gandhi',
                'content' => 'In a gentle way, you can shake the world.',
            ],
            [
                'author' => 'Roy T. Bennett',
                'content' => 'Don’t be pushed around by the fears in your mind. Be led by the dreams in your heart.',
            ],
            [
                'author' => 'Frank Ocean',
                'content' => 'Work hard in silence, let your success be the noise.',
            ],
            [
                'author' => 'H. Jackson Brown Jr.',
                'content' => 'Don’t say you don’t have enough time. You have exactly the same number of hours per day that were given to Helen Keller, Pasteur, Michelangelo, Mother Teresa, Leonardo Da Vinci, Thomas Jefferson, and Albert Einstein.',
            ],
            [
                'author' => 'Tim Notke',
                'content' => 'Hard work beats talent when talent doesn’t work hard.',
            ],
            [
                'author' => 'Mario Andretti',
                'content' => 'If everything seems to be under control, you’re not going fast enough.',
            ],
            [
                'author' => 'Thomas Edison',
                'content' => 'Opportunity is missed by most people because it is dressed in overalls and looks like work.',
            ],
            [
                'author' => 'Jimmy Johnson',
                'content' => 'The only difference between ordinary and extraordinary is that little extra.',
            ],
            [
                'author' => 'Oscar Wilde',
                'content' => 'The best way to appreciate your job is to imagine yourself without one.',
            ],
            [
                'author' => 'Benjamin Hardy',
                'content' => 'Unsuccessful people make their decisions based on their current situations. Successful people make their decisions based on where they want to be.',
            ],
            [
                'author' => 'Kamari aka Lyrikal',
                'content' => 'Never stop doing your best just because someone doesn’t give you credit.',
            ],
            [
                'author' => 'Conan O’Brien',
                'content' => 'Work hard, be kind, and amazing things will happen.',
            ],
            [
                'author' => 'Mother Teresa',
                'content' => 'The miracle is not that we do this work, but that we are happy to do it.',
            ],
            [
                'author' => 'Earl Nightingale',
                'content' => 'Never give up on a dream just because of the time it will take to accomplish it. The time will pass anyway.',
            ],
            [
                'author' => 'Kenneth Goldsmith',
                'content' => 'If you work on something a little bit every day, you end up with something that is massive.',
            ],
            [
                'author' => 'Oprah Winfrey',
                'content' => 'The big secret in life is that there is no secret. Whatever your goal, you can get there if you’re willing to work.',
            ],
            [
                'author' => 'Napoleon Hill',
                'content' => 'If you cannot do great things, do small things in a great way.',
            ],
            [
                'author' => 'Eleanor Roosevelt',
                'content' => 'Never allow a person to tell you no who doesn’t have the power to say yes.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'At any given moment you have the power to say: this is not how the story is going to end.',
            ],
            [
                'author' => 'Stephen King',
                'content' => 'Amateurs sit around and wait for inspiration. The rest of us just get up and go to work.',
            ],
            [
                'author' => 'Maya Angelou',
                'content' => 'Nothing will work unless you do.',
            ],
            [
                'author' => 'Christine Caine',
                'content' => 'Sometimes when you’re in a dark place you think you’ve been buried but you’ve actually been planted.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Don’t limit your challenges. Challenge your limits.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Whenever you find yourself doubting how far you can go, just remember how far you have come.',
            ],
            [
                'author' => 'Anne Frank',
                'content' => 'Everyone has inside them a piece of good news. The good news is you don’t know how great you can be! How much you can love! What you can accomplish! And what your potential is.',
            ],
            [
                'author' => 'Garrison Keillor',
                'content' => 'Some luck lies in not getting what you thought you wanted but getting what you have, which once you have got it you may be smart enough to see is what you would have wanted had you known.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Don’t quit yet, the worst moments are usually followed by the most beautiful silver linings. You have to stay strong, remember to keep your head up and remain hopeful.',
            ],
            [
                'author' => 'John F Kennedy',
                'content' => 'When written in Chinese the word “crisis” is composed of two characters – one represents danger and the other represents opportunity.',
            ],
            [
                'author' => 'St. Jerome',
                'content' => 'Good. Better. Best. Never let it rest. ‘Til your good is better and your better is best.',
            ],
            [
                'author' => 'Albert Einstein',
                'content' => 'In the middle of every difficulty lies opportunity.',
            ],
            [
                'author' => 'Arthur Ashe',
                'content' => 'Start where you are. Use what you have. Do what you can.',
            ],
            [
                'author' => 'John C. Maxwell',
                'content' => 'Dreams don’t work unless you do.',
            ],
            [
                'author' => 'Dr. Wayne D. Dyer',
                'content' => 'Go the extra mile. It’s never crowded there.',
            ],
            [
                'author' => 'Walt Whitman',
                'content' => 'Keep your face always toward the sunshine – and shadows will fall behind you.',
            ],
            [
                'author' => 'Lionel from Maid in Manhattan Movie',
                'content' => 'What defines us is how well we rise after falling.',
            ],
            [
                'author' => 'John Wooden',
                'content' => 'Make each day your masterpiece.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'Wherever you go, go with all your heart.',
            ],
            [
                'author' => 'Oprah',
                'content' => 'Turn your wounds into wisdom.',
            ],
            [
                'author' => 'Helen Keller',
                'content' => 'We can do anything we want to if we stick to it long enough.',
            ],
            [
                'author' => 'John Cage',
                'content' => 'Begin anywhere.',
            ],
            [
                'author' => 'Pele',
                'content' => 'Success is no accident. It is hard work, perseverance, learning, studying, sacrifice and most of all, love of what you are doing or learning to do.',
            ],
            [
                'author' => 'Gabby Douglas',
                'content' => 'Every champion was once a contender that didn’t give up.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Don’t dream about success. Get out there and work for it.',
            ],
            [
                'author' => 'Warren Buffett',
                'content' => 'The difference between successful people and very successful people is that very successful people say ‘no’ to almost everything.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'You can cry, scream, and bang your head in frustration but keep pushing forward. It’s worth it.',
            ],
            [
                'author' => 'Muhammad Ali',
                'content' => 'I hated every minute of training, but I said, ‘Don’t quit. Suffer now and live the rest of your life as a champion.',
            ],
            [
                'author' => 'Chris Grosser',
                'content' => 'Opportunities don’t happen. You create them.',
            ],
            [
                'author' => 'Maya Angelou',
                'content' => 'Success is liking yourself, liking what you do, and liking how you do it.',
            ],
            [
                'author' => 'Katharine Hepburn',
                'content' => 'If you obey all the rules, you miss all the fun.',
            ],
            [
                'author' => 'Herb Brooks',
                'content' => 'You were born to be a player. You were meant to be here. This moment is yours.',
            ],
            [
                'author' => 'Yuri Kochiyama',
                'content' => 'Life is not what you alone make it. Life is the input of everyone who touched your life and every experience that entered it. We are all part of one another.',
            ],
            [
                'author' => 'Abraham Lincoln',
                'content' => 'When you reach the end of your rope, tie a knot and hang out.',
            ],
            [
                'author' => 'Mark Twain',
                'content' => 'Never regret anything that made you smile.',
            ],
            [
                'author' => 'Eleanor Roosevelt',
                'content' => 'You must do the thing you think you cannot do.',
            ],
            [
                'author' => 'Buddha',
                'content' => 'If you want to fly give up everything that weighs you down.',
            ],
            [
                'author' => 'Suzy Kassem',
                'content' => 'Doubt kills more dreams than failure ever will.',
            ],
            [
                'author' => 'Nelson Mandela',
                'content' => 'I never lose. Either I win or learn.',
            ],
            [
                'author' => 'Ken Poirot',
                'content' => 'Today is your opportunity to build the tomorrow you want.',
            ],
            [
                'author' => 'C.S. Lewis',
                'content' => 'Getting over a painful experience is much like crossing the monkey bars. You have to let go at some point in order to move forward.',
            ],
            [
                'author' => 'Tim Ferriss',
                'content' => 'Focus on being productive instead of busy.',
            ],
            [
                'author' => 'Martin Luther King Jr.',
                'content' => 'You don’t need to see the whole staircase, just take the first step.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'It’s not all sunshine and rainbows, but a good amount of it actually is.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'When someone says you can’t do it, do it twice and take pictures.',
            ],
            [
                'author' => 'Estee Lauder',
                'content' => 'I didn’t get there by wishing for it, but by working for it.',
            ],
            [
                'author' => 'Lalah Deliah',
                'content' => 'She remembered who she was and the game changed.',
            ],
            [
                'author' => 'Susan Fales-Hill',
                'content' => 'If you’re too comfortable, it’s time to move on. Terrified of what’s next? You’re on the right track.',
            ],
            [
                'author' => 'Helen Keller',
                'content' => 'Be happy with what you have while working for what you want.',
            ],
            [
                'author' => 'Arabic Proverb',
                'content' => 'Sunshine all the time makes a desert.',
            ],
            [
                'author' => 'Frank Sinatra',
                'content' => 'The big lesson in life is never be scared of anyone or anything.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'You’re so much stronger than your excuses',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Don’t compare yourself to others. Be like the sun and the moon and shine when it’s your time.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Don’t Quit.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Don’t tell everyone your plans, instead show them your results.',
            ],
            [
                'author' => 'Louise Hay',
                'content' => 'I choose to make the rest of my life, the best of my life.',
            ],
            [
                'author' => 'Maya Angelou',
                'content' => 'Nothing can dim the light that shines from within.',
            ],
            [
                'author' => 'Steve Martin',
                'content' => 'Be so good they can’t ignore you.',
            ],
            [
                'author' => 'Hillary Clinton',
                'content' => 'Take criticism seriously, but not personally. If there is truth or merit in the criticism, try to learn from it. Otherwise, let it roll right off you.',
            ],
            [
                'author' => 'Reese Evans',
                'content' => 'This is a reminder to you to create your own rule book, and live your life the way you want it.',
            ],
            [
                'author' => 'Angelina Jolie',
                'content' => 'If you don’t get out of the box you’ve been raised in, you won’t understand how much bigger the world is.',
            ],
            [
                'author' => 'John Wooden',
                'content' => 'Do the best you can. No one can do more than that.',
            ],
            [
                'author' => 'Theodore Roosevelt',
                'content' => 'Do what you can, with what you have, where you are.',
            ],
            [
                'author' => 'George Eliot',
                'content' => 'It’s never too late to be what you might’ve been.',
            ],
            [
                'author' => 'Walt Disney',
                'content' => 'If you can dream it, you can do it.',
            ],
            [
                'author' => 'Baz Luhrmann',
                'content' => 'Trust yourself that you can do it and get it.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Don’t let what you can’t do interfere with what you can do.',
            ],
            [
                'author' => 'Benjamin Franklin',
                'content' => 'You can do anything you set your mind to.',
            ],
            [
                'author' => 'David Axelrod',
                'content' => 'All we can do is the best we can do.',
            ],
            [
                'author' => 'William Cobbett',
                'content' => 'You never know what you can do until you try.',
            ],
            [
                'author' => 'Mark Twain',
                'content' => 'Twenty years from now you’ll be more disappointed by the things you did not do than the ones you did.',
            ],
            [
                'author' => 'Wayne W. Dyer',
                'content' => 'I am thankful for all of those who said NO to me. It’s because of them I’m doing it myself.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'It’s okay to outgrow people who don’t grow. Grow tall anyways.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'When you feel like giving up just remember that there are a lot of people you still have to prove wrong.',
            ],
            [
                'author' => 'Nishan Panwar',
                'content' => 'The world is full of nice people. If you can’t find one, be one.',
            ],
            [
                'author' => 'Chantal Sutherland',
                'content' => 'Believe in yourself, take on your challenges, dig deep within yourself to conquer fears. Never let anyone bring you down. You got to keep going.',
            ],
            [
                'author' => 'Tsang Lindsay',
                'content' => 'A walk to a nearby park may give you more energy and inspiration in life than spending two hours in front of a screen.',
            ],
            [
                'author' => 'Tony Gaskins',
                'content' => 'If you can’t do anything about it then let it go. Don’t be a prisoner to things you can’t change.',
            ],
            [
                'author' => 'C.S. Lewis',
                'content' => 'You can’t go back and change the beginning, but you can start where you are and change the ending.',
            ],
            [
                'author' => 'Rumi',
                'content' => 'Yesterday I was clever, so I wanted to change the world. Today I am wise, so I am changing myself.',
            ],
            [
                'author' => 'Carrie Green',
                'content' => 'I can and I will. Watch me.',
            ],
            [
                'author' => 'Albert Einstein',
                'content' => 'Try not to become a man of success, but rather become a man of value.',
            ],
            [
                'author' => 'Nelson Mandela',
                'content' => 'A winner is a dreamer who never gives up.',
            ],
            [
                'author' => 'Jack Welch',
                'content' => 'If you don’t have a competitive advantage, don’t compete.',
            ],
            [
                'author' => 'Jordan Belfort',
                'content' => 'The only thing standing in the way between you and your goal is the BS story you keep telling yourself as to why you can’t achieve it.',
            ],
            [
                'author' => 'J.K. Rowling',
                'content' => 'What is life without a little risk?',
            ],
            [
                'author' => 'Princess Diana',
                'content' => 'Only do what your heart tells you.',
            ],
            [
                'author' => 'Grace Hopper',
                'content' => 'If it’s a good idea, go ahead and do it. It’s much easier to apologize than it is to get permission.',
            ],
            [
                'author' => 'Florence Nightingale',
                'content' => 'I attribute my success to this: I never gave or took an excuse.',
            ],
            [
                'author' => 'Ayn Rand',
                'content' => 'The question isn’t who is going to let me; it’s who is going to stop me.',
            ],
            [
                'author' => 'Sonia Sotomayer',
                'content' => 'A surplus of effort could overcome a deficit of confidence.',
            ],
            [
                'author' => 'Paulo Coelho',
                'content' => 'And, when you want something, all the universe conspires in helping you to achieve it.',
            ],
            [
                'author' => 'Marianne Williamson',
                'content' => 'Your playing small does not serve the world. There is nothing enlightened about shrinking so that other people won’t feel insecure around you. We are all meant to shine, as children do.',
            ],
            [
                'author' => 'Sarah Dessen',
                'content' => 'Don’t think or judge, just listen.',
            ],
            [
                'author' => 'Maya Angelou',
                'content' => 'I can be changed by what happens to me. But I refuse to be reduced by it.',
            ],
            [
                'author' => 'Martin Luther King Jr.',
                'content' => 'Darkness cannot drive out darkness: only light can do that. Hate cannot drive out hate: only love can do that.',
            ],
            [
                'author' => 'Dr. Seuss',
                'content' => 'You have brains in your head. You have feet in your shoes. You can steer yourself any direction you choose. You’re on your own. And you know what you know. And YOU are the one who’ll decide where to go…',
            ],
            [
                'author' => 'Paulo Coelho',
                'content' => 'It’s the possibility of having a dream come true that makes life interesting.',
            ],
            [
                'author' => 'J.R.R. Tolkien',
                'content' => 'There is some good in this world, and it’s worth fighting for.',
            ],
            [
                'author' => 'Roy T. Bennett',
                'content' => 'Learn to light a candle in the darkest moments of someone’s life. Be the light that helps others see; it is what gives life its deepest significance.',
            ],
            [
                'author' => 'Harper Lee',
                'content' => 'Atticus, he was real nice.” “Most people are, Scout, when you finally see them.',
            ],
            [
                'author' => 'The Lion King',
                'content' => 'Oh yes, the past can hurt. But the way I see it, you can either run from it or learn from it.',
            ],
            [
                'author' => 'Mary Poppins',
                'content' => 'We’re on the brink of adventure, children. Don’t spoil it with questions.',
            ],
            [
                'author' => 'Ferris Bueller',
                'content' => 'Life moves pretty fast. If you don’t stop and look around once in a while, you could miss it.',
            ],
            [
                'author' => 'Pretty in Pink',
                'content' => 'I just wanna let them know that they didn’t break me.',
            ],
            [
                'author' => 'The Godfather',
                'content' => 'I’m going to make him an offer he can’t refuse.',
            ],
            [
                'author' => 'The Greatest Showman',
                'content' => 'No one has ever made a difference by being like everyone else.',
            ],
            [
                'author' => 'The Breakfast Club',
                'content' => 'Spend a little more time trying to make something of yourself and a little less time trying to impress people.',
            ],
            [
                'author' => 'Pirates of the Caribbean',
                'content' => 'The problem is not the problem. The problem is your attitude about the problem.',
            ],
            [
                'author' => 'Snow White',
                'content' => 'Remember you’re the one who can fill the world with sunshine.',
            ],
            [
                'author' => 'Good Will Hunting',
                'content' => 'You’ll have bad times, but it’ll always wake you up to the good stuff you weren’t paying attention to.',
            ],
            [
                'author' => 'I Hope You Dance, Lee Ann Womack',
                'content' => 'And when you get the choice to sit it out or dance… I hope you dance.',
            ],
            [
                'author' => 'P!nk',
                'content' => 'Just because it burns doesn’t mean you’re gonna die you’ve gotta get up and try.',
            ],
            [
                'author' => 'Avicii',
                'content' => 'Life’s a game made for everyone and love is the prize.',
            ],
            [
                'author' => 'Michael Buble',
                'content' => 'It’s a new dawn, it’s a new day, it’s a life for me and I’m feeling good.',
            ],
            [
                'author' => 'Natasha Bedingfield',
                'content' => 'Today is where your book begins, the rest is still unwritten.',
            ],
            [
                'author' => 'The Greatest Showman',
                'content' => 'A million dreams for the world we’re gonna make.',
            ],
            [
                'author' => 'Bon Jovi',
                'content' => 'It’s my life It’s now or never I ain’t gonna live forever I just want to live while I’m alive',
            ],
            [
                'author' => 'Taylor Swift',
                'content' => 'I could build a castle out of all the bricks they threw at me.',
            ],
            [
                'author' => 'Demi Lovato',
                'content' => 'Cause the grass is greener under me bright as technicolor, I can tell that you can see.',
            ],
            [
                'author' => 'John Legend and Common',
                'content' => 'Every day women and men become legends.',
            ],
            [
                'author' => 'Oprah Winfrey',
                'content' => 'On my own I will just create and if it works, it works. And if it doesn’t, I’ll just create something else. I don’t have any limitations on what I think I could do or be.',
            ],
            [
                'author' => 'Malala Yousafzai',
                'content' => 'We realize the importance of our voices only when we are silenced.',
            ],
            [
                'author' => 'Janis Joplin',
                'content' => 'Don’t compromise yourself. You’re all you’ve got.',
            ],
            [
                'author' => 'Sara Blakely',
                'content' => 'When something I can’t control happens, I ask myself: Where is the hidden gift? Where is the positive in this?',
            ],
            [
                'author' => 'Jennifer Lopez',
                'content' => 'Doubt is a killer. You just have to know who you are and what you stand for.',
            ],
            [
                'author' => 'Judy Garland',
                'content' => 'Be a first rate version of yourself, not a second rate version of someone else.',
            ],
            [
                'author' => 'Eleanor Roosevelt',
                'content' => 'Learn from the mistakes of others. You can’t live long enough to make them all yourself.',
            ],
            [
                'author' => 'Joan Rivers',
                'content' => 'I was smart enough to go through any door that opened.',
            ],
            [
                'author' => 'Sheryl Sandberg',
                'content' => 'Done is better than perfect.',
            ],
            [
                'author' => 'Richard Branson',
                'content' => 'If your dreams don’t scare you, they are too small.',
            ],
            [
                'author' => 'Rumi',
                'content' => 'What hurts you blesses you.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Nothing is stronger than a broken man rebuilding himself.',
            ],
            [
                'author' => 'Kendrick Lamar',
                'content' => 'I always thought it was me against the world and then one day I realized it’s just me against me.',
            ],
            [
                'author' => 'Richard Nixon',
                'content' => 'A man is not finished when he is defeated. He is finished when he quits.',
            ],
            [
                'author' => 'Paulo Coelho',
                'content' => 'The world is changed by your example, not by your opinion.',
            ],
            [
                'author' => 'Dhirubhai Ambani',
                'content' => 'If you don’t build your dream, someone else will hire you to help them build theirs.',
            ],
            [
                'author' => 'Bruce Lee',
                'content' => 'I’m not in this world to live up to your expectations and you’re not in this world to live up to mine.',
            ],
            [
                'author' => 'Robin Williams',
                'content' => 'What’s right is what’s left if you do everything else wrong.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Be a fruitloop in a world of Cheerios.',
            ],
            [
                'author' => 'Spencer W. Kimball',
                'content' => 'Dream beautiful dreams, and then work to make those dreams come true.',
            ],
            [
                'author' => 'Mahatma Gandhi',
                'content' => 'Be the change you want to see in the world.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Believe you can and you will.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Do the right thing even when no one is looking.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Make today the day you learn something new.',
            ],
            [
                'author' => 'Ralph Waldo Emerson',
                'content' => 'Be silly, be honest, be kind.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'If you think someone could use a friend. Be one.',
            ],
            [
                'author' => 'Epictetus',
                'content' => 'It’s not what happens to you but how you react to it that matters.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'You don’t have to be perfect to be amazing.',
            ],
            [
                'author' => 'Abraham Lincoln',
                'content' => 'The best way to predict your future is to create it.',
            ],
            [
                'author' => 'G.K. Nielson',
                'content' => 'Successful people are not gifted; they just work hard, then succeed on purpose.',
            ],
            [
                'author' => 'Sam Levenson',
                'content' => 'Don’t watch the clock; do what it does. Keep going.',
            ],
            [
                'author' => 'Drake',
                'content' => 'Work until your rivals become idols.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'You can’t have a million dollar dream on a minimum wage work ethic.',
            ],
            [
                'author' => 'Eleanor Roosevelt',
                'content' => 'You must do the kind of things you think you cannot do.',
            ],
            [
                'author' => 'Jenny Craig',
                'content' => 'It’s not what you do once in a while it’s what you do day in and day out that makes the difference.',
            ],
            [
                'author' => 'Brian Vaszily',
                'content' => 'Falling down is how we grow. Staying down is how we die.',
            ],
            [
                'author' => 'Chris Rock',
                'content' => 'Wealth isn’t about having a lot of money it’s about having a lot of options.',
            ],
            [
                'author' => 'Derek Jeter',
                'content' => 'There may be people that have more talent than you, but there’s no excuse for anyone to work harder than you.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Always be careful when you follow the masses. Sometimes the m is silent.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Never let anyone treat you like you’re regular glue. You’re glitter glue.',
            ],
            [
                'author' => 'Floor',
                'content' => 'If you fall – I’ll be there.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'When Plan “A” doesn’t work, don’t worry, you still have 25 more letters to go through.',
            ],
            [
                'author' => 'Dalai Lama',
                'content' => 'If you think you’re too small to make a difference, try sleeping with a mosquito.',
            ],
            [
                'author' => 'Steven Wright',
                'content' => 'If at first you don’t succeed, then skydiving isn’t for you.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'A diamond is merely a lump of coal that did well under pressure.',
            ],
            [
                'author' => 'Groucho Marx',
                'content' => 'I find television very educational. Every time someone turns it on, I go in the other room and read a book.',
            ],
            [
                'author' => 'Kyle Chandler',
                'content' => 'Opportunity does not knock, it presents itself when you beat down the door.',
            ],
            [
                'author' => 'Thomas A. Edison',
                'content' => 'I have not failed. I’ve just found 10,000 ways that won’t work.',
            ],
            [
                'author' => 'Sarah J. Maas',
                'content' => 'You could rattle the stars,” she whispered. “You could do anything, if only you dared. And deep down, you know it, too. That’s what scares you most.',
            ],
            [
                'author' => 'Walter Anderson',
                'content' => 'It is only when we take chances, when our lives improve. The initial and the most difficult risk that we need to take is to become honest.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'When you know your worth, no one can make you feel worthless.',
            ],
            [
                'author' => 'Johann Wolfgang von Goethe',
                'content' => 'If you’ve never eaten while crying you don’t know what life tastes like.',
            ],
            [
                'author' => 'Mother Teresa',
                'content' => 'If you judge people, you have no time to love them.',
            ],
            [
                'author' => 'Douglas Adams',
                'content' => 'Once you do know what the question actually is, you’ll know what the answer means.',
            ],
            [
                'author' => 'Mark Twain',
                'content' => 'The two most important days in your life are the day you’re born and the day you find out why.',
            ],
            [
                'author' => 'Pema Chodron',
                'content' => 'Nothing ever goes away until it teaches us what we need to know.',
            ],
            [
                'author' => 'Bruce Lee',
                'content' => 'We can see through others only when we can see through ourselves.',
            ],
            [
                'author' => 'Jim Rohn',
                'content' => 'You don’t get paid for the hour. You get paid for the value you bring to the hour.',
            ],
            [
                'author' => 'Louise L Hay',
                'content' => 'Remember, you have been criticizing yourself for years and it hasn’t worked. Try approving of yourself and see what happens.',
            ],
            [
                'author' => 'Tena Desae',
                'content' => 'Work hard and don’t give up hope. Be open to criticism and keep learning. Surround yourself with happy, warm and genuine people.',
            ],
            [
                'author' => 'Ali Krieger',
                'content' => 'You can control two things: your work ethic and your attitude about anything.',
            ],
            [
                'author' => 'Dwayne Johnson',
                'content' => 'Success isn’t always about greatness. It’s about consistency. Consistent hard work leads to success. Greatness will come.',
            ],
            [
                'author' => 'Lady Gaga',
                'content' => 'Some women choose to follow men, and some women choose to follow their dreams. If you’re wondering which way to go, remember that your career will never wake up and tell you that it doesn’t love you anymore.',
            ],
            [
                'author' => 'Mufti Menk',
                'content' => 'I really appreciate people who correct me, because without them, I might have been repeating mistakes for a long time.',
            ],
            [
                'author' => 'Sheryl Sandberg',
                'content' => 'Motivation comes from working on things we care about.',
            ],
            [
                'author' => 'David A. Bednar',
                'content' => 'If today you are a little bit better than you were yesterday, then that’s enough.',
            ],
            [
                'author' => 'Nelson Mandela',
                'content' => 'Education is the most powerful weapon which you can use to change the world.',
            ],
            [
                'author' => 'Marva Collin',
                'content' => 'If you can’t make a mistake you can’t make anything.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Practice makes progress not perfect.',
            ],
            [
                'author' => 'Beverly Sills',
                'content' => 'You may be disappointed if you fail, but you’ll be doomed if you don’t try.',
            ],
            [
                'author' => 'Walter Brunell',
                'content' => 'Failure is the tuition you pay for success.',
            ],
            [
                'author' => 'Lemony Snicket',
                'content' => 'If we wait until we’re ready, we’ll be waiting for the rest of our lives.',
            ],
            [
                'author' => 'William Arthur Ward',
                'content' => 'Study while others are sleeping; work while others are loafing; prepare while others are playing; and dream while others are wishing.',
            ],
            [
                'author' => 'Frank Sinatra',
                'content' => 'The best revenge is massive success.',
            ],
            [
                'author' => 'Jamie Foxx',
                'content' => 'What’s on the other side of fear? Nothing.',
            ],
            [
                'author' => 'Dr. Irene C. Kassorla',
                'content' => 'Quitters never win. Winners never quit!',
            ],
            [
                'author' => 'Charles A. Jaffe',
                'content' => 'It’s not your salary that makes you rich, it’s your spending habits.',
            ],
            [
                'author' => 'Latin Proverb',
                'content' => 'If there is no wind, row.',
            ],
            [
                'author' => 'Joyce Meyers',
                'content' => 'It’s never too late for a new beginning in your life.',
            ],
            [
                'author' => 'Milton Berle',
                'content' => 'If opportunity doesn’t knock build a door.',
            ],
            [
                'author' => 'Pablo Picasso',
                'content' => 'Action is the foundational key to all success.',
            ],
            [
                'author' => 'Estee Lauder',
                'content' => 'I never dreamt of success. I worked for it.',
            ],
            [
                'author' => 'Napoleon Hill',
                'content' => 'A goal is a dream with a deadline.',
            ],
            [
                'author' => 'Mahatma Gandhi',
                'content' => 'Be the change that you wish to see in the world.',
            ],
            [
                'author' => 'Margaret Mead',
                'content' => 'Never doubt that a small group of thoughtful, committed, citizens can change the world. Indeed, it is the only thing that ever has.',
            ],
            [
                'author' => 'Mandy Hale',
                'content' => 'Change is painful, but nothing is as painful as staying stuck somewhere you don’t belong.',
            ],
            [
                'author' => 'George Bernard Shaw',
                'content' => 'Those who cannot change their minds cannot change anything.',
            ],
            [
                'author' => 'Leo Tolstoy',
                'content' => 'Everyone thinks of changing the world, but no one thinks of changing himself.',
            ],
            [
                'author' => 'John F. Kennedy',
                'content' => 'Change is the law of life. And those who look only to the past or present are certain to miss the future.',
            ],
            [
                'author' => 'Maya Angelou',
                'content' => 'We delight in the beauty of the butterfly, but rarely admit the changes it has gone through to achieve that beauty.',
            ],
            [
                'author' => 'Debby Boone',
                'content' => 'Dreams are the seeds of change. Nothing ever grows without a seed, and nothing ever changes without a dream.',
            ],
            [
                'author' => 'George Burns',
                'content' => 'Don’t stay in bed unless you can make money in bed.',
            ],
            [
                'author' => 'Dave Ramsey',
                'content' => 'You must gain control over your money or the lack of it will forever control you.',
            ],
            [
                'author' => 'Warren Buffett',
                'content' => 'Only buy something that you’d be perfectly happy to hold if the market shuts down for ten years.',
            ],
            [
                'author' => 'Henry David Thoreau',
                'content' => 'That man is richest whose pleasures are cheapest.',
            ],
            [
                'author' => 'Clare Boothe Luce',
                'content' => 'Money can’t buy happiness, but it can make you awfully comfortable while you’re being miserable.',
            ],
            [
                'author' => 'Jen Sincero',
                'content' => 'Money is only a tool. It will take you wherever you wish, but it will not replace you as the driver.',
            ],
            [
                'author' => 'Maya Angelou',
                'content' => 'You can only become truly accomplished at something you love. Don’t make money your goal. Instead pursue the things you love doing and then do them so well that people can’t take their eyes off of you.',
            ],
            [
                'author' => 'Jim Rohn',
                'content' => 'Formal education will make you a living; self-education will make you a fortune.',
            ],
            [
                'author' => 'Sophia Amoruso',
                'content' => 'Don’t give up, don’t take anything personally, and don’t take no for an answer.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Don’t be upset when people reject you. Nice things are rejected all the time by people who can’t afford them.',
            ],
            [
                'author' => 'Socrates',
                'content' => 'The secret of change is to focus all your energy, not on fighting the old, but on building the new.',
            ],
            [
                'author' => 'Roger H. Lincoln',
                'content' => 'There are two rules for success. 1: Never reveal everything you know.',
            ],
            [
                'author' => 'Shiv Khera',
                'content' => 'Your positive action combined with positive thinking results in success.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'If you talk about it, it’s a dream. If you envision it, it’s possible. If you schedule it, it’s real.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Forget your excuses. You either want it bad or don’t want it at all.',
            ],
            [
                'author' => 'Marie Forleo',
                'content' => 'The key to success is to start before you are ready.',
            ],
            [
                'author' => 'Dr. Dorothy Height',
                'content' => 'I want to be remembered as the one who tried.',
            ],
            [
                'author' => 'Matt Haig',
                'content' => 'How to stop time: kiss. How to travel in time: read. How to escape time: music. How to feel time: write. How to release time: breathe.',
            ],
            [
                'author' => 'William Penn',
                'content' => 'Time is what we want most and what we use worst.',
            ],
            [
                'author' => 'Rachael Bermingham',
                'content' => 'It’s not about having enough time, it’s about making enough time.',
            ],
            [
                'author' => 'Benjamin Franklin',
                'content' => 'Time is money.',
            ],
            [
                'author' => 'William Shakespeare',
                'content' => 'Better three hours too soon than a minute too late.',
            ],
            [
                'author' => 'Buddha',
                'content' => 'The trouble is, you think you have time.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'The greatest gift you could give someone is your time. Because when you give your time, you are giving a portion of your life you can’t get back.',
            ],
            [
                'author' => 'Amit Kalantri',
                'content' => 'Punctuality is not just limited to arriving at a place at right time, it is also about taking actions at right time.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Time always exposes what you mean to someone.',
            ],
            [
                'author' => 'J.K. Rowling',
                'content' => 'After all this time? Always.',
            ],
            [
                'author' => 'Barack Obama',
                'content' => 'You can’t let your failures define you. You have to let your failures teach you.',
            ],
            [
                'author' => 'Bill Gates',
                'content' => 'Success is a lousy teacher. It seduces smart people into thinking they can’t lose.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'Stop being afraid of what could go wrong, and start being excited about what could go right.',
            ],
            [
                'author' => 'Oprah',
                'content' => 'Think like a Queen. A Queen is not afraid to fail. Failure is another stepping stone to greatness.',
            ],
            [
                'author' => 'Bruce Lee',
                'content' => 'Defeat is a state of mind; no one is ever defeated until defeat is accepted as a reality.',
            ],
            [
                'author' => 'Confucius',
                'content' => 'Our greatest glory is not in never falling, but in rising every time we fall.',
            ],
            [
                'author' => 'J.K. Rowling',
                'content' => 'It is impossible to live without failing at something, unless you live so cautiously that you might as well not have lived at all – in which case, you fail by default.',
            ],
            [
                'author' => 'Winston Churchill',
                'content' => 'Success is going from failure to failure without losing your enthusiasm.',
            ],
            [
                'author' => 'Komal Kapoor',
                'content' => 'Why do we grieve failures longer than we celebrate wins?',
            ],
            [
                'author' => 'Oprah Winfrey',
                'content' => 'Failure isn’t the end of the road. It’s a big red flag saying to you ‘Wrong way. Turn around.’',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Whenever you feel like a failure, just remember that even Coca Cola only sold 25 bottles their first year.',
            ],
            [
                'author' => 'Robin Williams',
                'content' => 'No matter what people tell you, words and ideas can change the world.',
            ],
            [
                'author' => 'Albert Einstein',
                'content' => 'Life is like riding a bicycle. To keep your balance, you must keep moving.',
            ],
            [
                'author' => 'Dr. Seuss',
                'content' => 'You’re off to Great Places! Today is your day! Your mountain is waiting, so… get on your way!',
            ],
            [
                'author' => 'Unknown',
                'content' => 'When thinking about life, remember this: no amount of guilt can change the past and no amount of anxiety can change the future.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'A negative mind will never give you a positive life.',
            ],
            [
                'author' => 'Goethe',
                'content' => 'Everything is hard before it is easy.',
            ],
            [
                'author' => 'Frida Kahlo',
                'content' => 'At the end of the day we can endure much more than we think we can.',
            ],
            [
                'author' => 'Frank Ocean',
                'content' => 'Whatever you do never run back to what broke you.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Take the risk or lose the chance.',
            ],
            [
                'author' => 'Ursula Burns',
                'content' => 'I didn’t learn to be quiet when I had an opinion. The reason they knew who I was is because I told them.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Never regret a day in your life. Good days bring you happiness and bad days give you experience.',
            ],
            [
                'author' => 'Jim Rohn',
                'content' => 'Either you run the day, or the day runs you.',
            ],
            [
                'author' => 'Carol Burnett',
                'content' => 'Only I can change my life. No one can do it for me.',
            ],
            [
                'author' => 'Charles R. Swindoll',
                'content' => 'Life is 10% what happens to you and 90% how you react to it.',
            ],
            [
                'author' => 'William James',
                'content' => 'Act as if what you do makes a difference. It does.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'When the pain of an obstacle is too great, challenge yourself to be stronger.',
            ],
            [
                'author' => 'Will Rogers',
                'content' => 'Even if you’re on the right track, you’ll get run over if you just sit there.',
            ],
            [
                'author' => 'Marcus Aurelius',
                'content' => 'Very little is needed to make a happy life; it is all within yourself, in your way of thinking.',
            ],
            [
                'author' => 'Helen Keller',
                'content' => 'Life is either a daring adventure or nothing at all.',
            ],
            [
                'author' => 'Albert Einstein',
                'content' => 'The woman who follows the crowd will usually go no further than the crowd. The woman who walks alone is likely to find herself in places no one has been before.',
            ],
            [
                'author' => 'Jim Hensen',
                'content' => 'Life’s like a movie, write your own ending. Keep believing, keep pretending.',
            ],
            [
                'author' => 'George R.R. Martin',
                'content' => 'A reader lives a thousand lives before he dies. The man who never reads lives only one.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Never stop learning because life never stops teaching.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'If you’re the smartest person in the room, you’re in the wrong room.',
            ],
            [
                'author' => 'Brian Herbert',
                'content' => 'The capacity to learn is a gift; the ability to learn is a skill; the willingness to learn is a choice.',
            ],
            [
                'author' => 'Mark Twain',
                'content' => 'The man who does not read has no advantage over the man who cannot read.',
            ],
            [
                'author' => 'Chinese Proverb',
                'content' => 'To learn a language is to have one more window from which to look at the world.',
            ],
            [
                'author' => 'Michelangelo',
                'content' => 'I’m still learning.',
            ],
            [
                'author' => 'Mahatma Gandhi',
                'content' => 'Live as if you were to die tomorrow. Learn as if you were to live forever.',
            ],
            [
                'author' => 'Nelson Mandela',
                'content' => 'Education is the most powerful weapon you can use to change the world.',
            ],
            [
                'author' => 'Arnold Schwarzenegger',
                'content' => 'Strength does not come from winning. Your struggles develop your strengths. When you go through hardships and decide not to surrender, that is strength.',
            ],
            [
                'author' => 'Fred DeVito',
                'content' => 'If it doesn’t challenge you, it doesn’t change you.',
            ],
            [
                'author' => 'Colin Powell',
                'content' => 'A dream doesn’t become reality through magic; it takes sweat, determination and hard work.',
            ],
            [
                'author' => 'R.H. Sin',
                'content' => 'Every night her thoughts weighed heavily on her soul but every morning she would get up and fight another day, every night she survived.',
            ],
            [
                'author' => 'Maya Angelou',
                'content' => 'Still, I rise.',
            ],
            [
                'author' => 'Mama Indigo',
                'content' => 'The best thing you can do is MASTER the chaos in you. You are not thrown into the fire, you ARE the fire.',
            ],
            [
                'author' => 'Jennae Cecilia',
                'content' => 'Flowers grow back even after the harshest winters. You will too.',
            ],
            [
                'author' => 'Paulo Coelho',
                'content' => 'Life has many ways of testing a person’s will, either by having nothing happen at all or by having everything happen all at once.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Be strong enough to let go and wise enough to wait for what you deserve.',
            ],
            [
                'author' => 'Jadah Sellner',
                'content' => 'It’s okay to be a glowstick: Sometimes we have to break before we shine.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'What is coming is better than what is gone.',
            ],
            [
                'author' => 'Roy T. Bennett',
                'content' => 'Attitude is a choice. Happiness is a choice. Optimism is a choice. Kindness is a choice. Giving is a choice. Respect is a choice. Whatever choice you make makes you. Choose wisely.',
            ],
            [
                'author' => 'Marcus Aurelius',
                'content' => 'Dwell on the beauty of life. Watch the stars, and see yourself running with them.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Do something today that your future self will thank you for.',
            ],
            [
                'author' => 'William James',
                'content' => 'The greatest weapon against stress is the ability to choose one thought over another.',
            ],
            [
                'author' => 'Hans F. Hansen',
                'content' => 'It takes nothing to join the crowd. It takes everything to stand alone.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Your mind is powerful. When you fill it with positive thoughts your whole world will change.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Your only limit is your mind.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Stop being afraid of what can go wrong and start being positive about what can go right.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'The difference between who you are and who you want to be is what you do.',
            ],
            [
                'author' => 'Zig Ziglar',
                'content' => 'You were born to win, but to be a winner, you must plan to win, prepare to win, and expect to win.',
            ],
            [
                'author' => 'Kylie Francis',
                'content' => 'One thing’s for sure, if you don’t play, you don’t win.',
            ],
            [
                'author' => 'Vince Lombardi',
                'content' => 'Winning means you’re willing to go longer, work harder, and give more than anyone else.',
            ],
            [
                'author' => 'Michael Jordan',
                'content' => 'Talent wins games, but teamwork wins championships.',
            ],
            [
                'author' => 'Nicki Minaj',
                'content' => 'When I win and when I lose, I take ownership of it, because I really am in charge of what I do.',
            ],
            [
                'author' => 'Billie Jean King',
                'content' => 'A champion is afraid of losing. Everyone else is afraid of winning.',
            ],
            [
                'author' => 'Joe Torre',
                'content' => 'Competing at the highest level is not about winning. It’s about preparation, courage, understanding, nurturing your people, and heart. Winning is the result.',
            ],
            [
                'author' => 'Mike Murdock',
                'content' => 'The secret of your future is hidden in your daily routine.',
            ],
            [
                'author' => 'Robert T. Kiyosaki',
                'content' => 'Losers quit when they fail. Winners fail until they succeed.',
            ],
            [
                'author' => 'George Eliot',
                'content' => 'It is never too late to be what you might have been.',
            ],
            [
                'author' => 'Brad Sugars',
                'content' => 'Words can inspire, thoughts can provoke, but only action truly brings you closer to your dreams.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Don’t stop when you are tired. Stop when you are done.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Don’t tell people about your dreams. Show them your dreams.',
            ],
            [
                'author' => 'Marcus Luttrell',
                'content' => 'Revenge is a powerful motivator.',
            ],
            [
                'author' => 'Miya Yamanouchi',
                'content' => 'Motivation may be what starts you off, but it’s habit that keeps you going back for more.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'I will not erase all my hard work this week because it’s the weekend.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'It might not be easy but it’ll be worth it.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'Make your fear of losing your greatest motivator.',
            ],
            [
                'author' => 'Unknown',
                'content' => 'You will never always be motivated, so you must learn to be disciplined.',
            ],
            [
                'author' => 'Stephen Covey',
                'content' => 'I’m not a product of my circumstances. I am a product of my decisions.',
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
        $this->quoteManager->bulkSave($quotes, (string) $this->getReference(UserAdminFixtures::ADMIN_USER_REFERENCE));
    }
}
