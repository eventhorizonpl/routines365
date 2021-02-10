<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\QuoteFactory;
use App\Manager\QuoteManager;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class V6QuoteFixtures extends Fixture implements FixtureGroupInterface
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
        return ['v6deployment'];
    }

    public function load(ObjectManager $manager): void
    {
        $dataset = [
            [
                'author' => 'Tony Robbins',
                'content' => 'The secret of success is learning how to use pain and pleasure instead of having pain and pleasure use you. If you do that, you’re in control of your life. If you don’t, life controls you.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'I’ve come to believe that all my past failure and frustration were actually laying the foundation for the understandings that have created the new level of living I now enjoy.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'Identify your problems, but give your power and energy to solutions.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'Life is a gift, and it offers us the privilege, opportunity, and responsibility to give something back by becoming more.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'A real decision is measured by the fact that you’ve taken a new action. If there’s no action, you haven’t truly decided.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'New Year = A New Life! Decide today who you will become, what you will give how you will live.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'Leaders spend 5% of their time on the problem & 95% of their time on the solution. Get over it & crush it!',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'One reason so few of us achieve what we truly want is that we never direct our focus; we never concentrate our power. Most people dabble their way through life, never deciding to master anything in particular.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'The only problem we really have is we think we’re not supposed to have problems! Problems call us to higher level - face & solve them now!',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'Your past does not equal your future.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'For changes to be of any true value, they’ve got to be lasting and consistent.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'I discovered a long time ago that if I helped enough people get what they wanted, I would always get what I wanted and I would never have to worry.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'Your life changes the moment you make a new, congruent, and committed decision.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'If you do what you’ve always done, you’ll get what you’ve always gotten.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'It is in your moments of decision that your destiny is shaped.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'In life you need either inspiration or desperation.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'Successful people ask better questions, and as a result, they get better answers.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'Things do not have meaning. We assign meaning to everything.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'Setting goals is the first step in turning the invisible into the visible.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'Only those who have learned the power of sincere and selfless contribution experience life’s deepest joy: true fulfillment.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'If you want to be successful, find someone who has achieved the results you want and copy what they do and you’ll achieve the same results.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'I challenge you to make your life a masterpiece. I challenge you to join the ranks of those people who live what they teach, who walk their talk.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'It is not what we get. But who we become, what we contribute… that gives meaning to our lives.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'People are not lazy. They simply have impotent goals – that is, goals that do not inspire them.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'Beliefs have the power to create and the power to destroy. Human beings have the awesome ability to take any experience of their lives and create a meaning that disempowers them or one that can literally save their lives.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'We can change our lives. We can do, have, and be exactly what we wish.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'We will act consistently with our view of who we truly are, whether that view is accurate or not.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'Everybody’s life is either rewarding or an example.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'Using the power of decision gives you the capacity to get past any excuse to change any and every part of your life in an instant.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'To effectively communicate, we must realize that we are all different in the way we perceive the world and use this understanding as a guide to our communication with others.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'It’s your unlimited power to care and to love that can make the biggest difference in the quality of your life.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'Lack of emotion causes lack of progress and lack of motivation.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'If you believe you are right, or you believe you are wrong, you’re right. Whenever you are certain about it, you will support it. Remember that.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'If you can’t, you must. If you must, you can.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'If you don’t set a baseline standard for what you’ll accept in life, you’ll find it’s easy to slip into behaviors and attitudes or a quality of life that’s far below what you deserve.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'Most people fail in life because they major in minor things.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'Most people have no idea of the giant capacity we can immediately command when we focus all of our resources on mastering a single area of our lives.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'Success is doing what you want to do, when you want, where you want, with whom you want, as much as you want.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'The only people without problems are those in cemeteries.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'Nothing has any power over me other than that which I give it through my conscious thoughts.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'It’s not knowing what to do; it’s doing what you know.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'Create a vision and never let the environment, other people’s beliefs, or the limits of what has been done in the past shape your decisions.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'The path to success is to take massive, determined action.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'It’s what you practice in private that you will be rewarded for in public.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'When you are grateful fear disappears and abundance appears.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'The quality of your life is the quality of your relationships.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'Your income right now is a result of your standards, it is not the industry, it is not the economy.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'There is no greatness without a passion to be great, whether it’s the aspiration of an athlete or an artist, a scientist, a parent, or a businessperson.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'Once you have mastered time, you will understand how true it is that most people overestimate what they can accomplish in a year – and underestimate what they can achieve in a decade.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'Commit to CANI! – Constant And Never-ending Improvement.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'Where focus goes, energy flows.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'The meeting of preparation with opportunity generates the offspring we call luck.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'You see, in life, lots of people know what to do, but few people actually do what they know. Knowing is not enough! You must take action.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'It’s not what we do once in a while that shapes our lives, but what we do consistently.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'Why live an ordinary life, when you can live an extraordinary one.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'The more rejection you get, the better you are, the more you’ve learned, the closer you are to your outcome… If you can handle rejection, you’ll learn to get everything you want.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'People who succeed at the highest level are not lucky; they’re doing something differently than everyone else.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'Life is found in the dance between your deepest desire and your greatest fear.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'Everybody’s got a past. The past does not equal the future unless you live there.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'Lasting change is different than a goal. You don’t always get your goals, but you always get your standards.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'Passion is the genesis of genius.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'Whatever happens, take responsibility.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'There’s always a way – if you’re committed.',
            ],
            [
                'author' => 'Tony Robbins',
                'content' => 'The secret to living is giving.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'Happiness is an incredible competitive advantage.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'Happiness is not the belief that we don’t need to change; it is the realization that we can.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'You can eliminate depression without making someone happy. You can cure anxiety without teaching someone optimism. You can return someone to work without improving their job performance.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'Without action, knowledge is often meaningless.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'Only 25 percent of job successes are predicted by IQ, 75 percent of job successes are predicted by your optimism levels, your social support, and your ability to see stress as a challenge instead of as a threat.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'If all you strive for is diminishing the bad, you’ll only attain the average and you’ll miss out entirely on the opportunity to exceed the average.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'Happiness asks us to be realistic about the present while maximizing our potential for the future.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'Happiness is about learning how to cultivate the mindset and behaviors that have been empirically proven to fuel greater success and fulfillment.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'Happiness is not just a mood — it’s a work ethic.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'The belief that we are just our genes is one of the most pernicious myths in modern culture — the insidious notion that people come into the world with a fixed set of abilities and that they, and their brains, cannot change.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'You do not have to be your genes, your childhood, your environment. We can choose how our brain looks at the world.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'For untold generations, we have been led to believe that happiness orbited around success. That if we work hard enough, we will be successful, and only if we are successful will we become happy. The opposite is true.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'When we are happy—when our mindset and mood are positive we are smarter, more motivated, and thus more successful. Happiness is the center, and success revolves around it.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'The most accurate term for happiness…is the one Aristotle used: eudaimonia, which translates not directly to ‘happiness’ but to ‘human flourishing’.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'Happiness is not all about yellow smiley faces and rainbows. For me, happiness is the joy we feel striving after our potential.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'Happiness precedes important outcomes and indicators of thriving. The wealth of data found that happiness causes success and achievement, not the opposite.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'Even the smallest shots of positivity can give someone a serious competitive edge.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'A quick burst of positive emotions doesn’t just broaden our cognitive capacity; it also provides a quick and powerful antidote to stress and anxiety, which in turn improves our focus and our ability to function at our best level.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'Research shows that regular meditation can permanently rewire the brain to raise levels of happiness, lower stress, even improve immune function.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'So how do the scientists define happiness? Essentially, as the experience of positive emotions — pleasure combined with deeper feelings of meaning and purpose.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'Happiness implies a positive mood in the present and a positive outlook for the future.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'Happiness gives us a real chemical edge on the competition. How? Positive emotions flood our brains with dopamine and serotonin, chemicals that not only make us feel good, but dial up the learning centers of our brains to higher levels.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'Positive emotions help us organize new information, keep that information in the brain longer, and retrieve it faster later on.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'Money can buy happiness, but only if used to DO things as opposed to simply HAVE things.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'The fastest way to disengage an employee is to tell him his work is meaningful only because of the paycheck.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'By changing the fulcrum of our mindset and lengthening our lever of possibility, we change what is possible. It’s not the weight of the world that determines what we can accomplish. It is our fulcrum and lever.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'Beliefs are so powerful because they dictate our efforts and actions.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'When our brains constantly scan for and focus on the positive, we profit from three of the most important tools available to us: happiness, gratitude, and optimism.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'The mental construction of our daily activities, more than the activity itself, defines our reality.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'When we reconnect ourselves with the pleasure of the ‘means,’ as opposed to only focusing on the ‘ends,’ we adopt a mindset more conducive not only to enjoyment, but to better results.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'The more you believe in your own ability to succeed, the more likely it is that you will.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'According to the Roman poet Ovid, the sculptor Pygmalion could look at a piece of marble and see the sculpture trapped inside of it.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'The Pygmalion Effect is when our belief in another person’s potential brings that potential to life.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'We want to push the limits of possibility as far as they can go, not limit them in the way too many discouraging bosses, parents, teachers, or media stories tell us they should be limited.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'You can study gravity forever without ever knowing how to fly.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'Simply believing we can fly won’t set us aloft. Yet if we don’t believe, we have no chance of ever making it off the ground.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'As science has shown, when we believe we can do more and achieve more (or when others believe it for us), that is often the precise reason we DO achieve more.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'Constantly scanning the world for the negative comes with a great cost. It undercuts our creativity, raises our stress levels, and lowers our motivation and ability to accomplish goals.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'It’s hard to find happiness after success if the goalposts of success keep changing.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'Successful people see adversity as a stepping stone rather than a stumbling block.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'You have to train your brain to be positive just like you work out your body.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'The greatest competitive advantage in our modern economy is a positive and engaged brain.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'Your brain at positive is 31 percent more productive than your brain at negative, neutral, or stressed.',
            ],
            [
                'author' => 'Shawn Achor',
                'content' => 'Mindfulness is a key cornerstone of creating a positive mind.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'No one lives long enough to learn everything they need to learn starting from scratch. To be successful, we absolutely, positively have to find people who have already paid the price to learn the things that we need to learn to achieve our goals.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'Successful people are always looking for opportunities to help others. Unsuccessful people are always asking, ‘What’s in it for me?’',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'The person we believe ourselves to be will always act in a manner consistent with our self-image.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'All successful people are big dreamers. They imagine what their future could be, ideal in every respect, and then they work every day toward their distant vision, that goal or purpose.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'You have to put in many, many, many tiny efforts that nobody sees or appreciates before you achieve anything worthwhile.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'Whatever we expect with confidence becomes our own self-fulfilling prophecy.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'The key to success is to focus our conscious mind on things we desire not things we fear.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'If you raise your children to feel that they can accomplish any goal or task they decide upon, you will have succeeded as a parent and you will have given your children the greatest of all blessings.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'Successful people are simply those with successful habits.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'The ability to discipline yourself to delay gratification in the short term in order to enjoy greater rewards in the long term, is the indispensable prerequisite for success.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'You have within you right now, everything you need to deal with whatever the world can throw at you.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'Teamwork is so important that it is virtually impossible for you to reach the heights of your capabilities or make the money that you want without becoming very good at it.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'The greatest gift that you can give to others is the gift of unconditional love and acceptance.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'I’ve found that luck is quite predictable. If you want more luck, take more chances. Be more active. Show up more often.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'Imagine no limitations; decide what’s right and desirable before you decide what’s possible.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'Whatever you believe with feeling becomes your reality.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'Everything you do is triggered by an emotion of either desire or fear.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'Never say anything about yourself you do not want to come true.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'Love only grows by sharing. You can only have more for yourself by giving it away to others.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'It doesn’t matter where you are coming from. All that matters is where you are going.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'Your greatest asset is your earning ability. Your greatest resource is your time.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'Those people who develop the ability to continuously acquire new and better forms of knowledge that they can apply to their work and to their lives will be the movers and shakers in our society for the indefinite future.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'Move out of your comfort zone. You can only grow if you are willing to feel awkward and uncomfortable when you try something new.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'The happiest people in the world are those who feel absolutely terrific about themselves, and this is the natural outgrowth of accepting total responsibility for every part of their life.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'If what you are doing is not moving you towards your goals, then it’s moving you away from your goals.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'Winners make a habit of manufacturing their own positive expectations in advance of the event.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'You cannot control what happens to you, but you can control your attitude toward what happens to you, and in that, you will be mastering change rather than allowing it to master you.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'Look for the good in every person and every situation. You’ll almost always find it.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'Communication is a skill that you can learn. If you’re willing to work at it, you can rapidly improve the quality of every part of your life.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'Goals allow you to control the direction of change in your favor.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'An attitude of positive expectation is the mark of the superior personality.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'Develop an attitude of gratitude, and give thanks for everything that happens to you, knowing that every step forward is a step toward achieving something bigger and better than your current situation.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'Decisiveness is a characteristic of high-performing men and women. Almost any decision is better than no decision at all.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'Only by contending with challenges that seem to be beyond your strength to handle at the moment you can grow more surely toward the stars.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'Invest three percent of your income in yourself (self-development) in order to guarantee your future.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'If you wish to achieve worthwhile things in your personal and career life, you must become a worthwhile person in your own self-development.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'The more you seek security, the less of it you have. But the more you seek opportunity, the more likely it is that you will achieve the security that you desire.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'Today the greatest single source of wealth is between your ears.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'Never complain, never explain. Resist the temptation to defend yourself or make excuses.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'Every minute you spend in planning saves 10 minutes in execution; this gives you a 1,000 percent Return on Energy!',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'The true measure of the value of any business leader and manager is performance.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'Just as your car runs more smoothly and requires less energy to go faster and farther when the wheels are in perfect alignment, you perform better when your thoughts, feelings, emotions, goals, and values are in balance.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'People with clear, written goals, accomplish far more in a shorter period of time than people without them could ever imagine.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'The more credit you give away, the more will come back to you. The more you help others, the more they will want to help you.',
            ],
            [
                'author' => 'Brian Tracy',
                'content' => 'Whatever you dwell on in the conscious grows in your experience.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'Working hard for something we don’t care about is called stress; working hard for something we love is called passion.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'A team is not a group of people that work together. A team is a group of people that trust each other.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'I find, when you’re an optimist, life has a funny way of looking after you.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'Life is beautiful not because of the things we see or do. Life is beautiful because of the people we meet.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'People don’t buy what you do; they buy why you do it. And what you do simply proves what you believe.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'Vision is the ability to talk about the future with such clarity it is as if we are talking about the past.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'It is better to disappoint people with the truth than to appease them with a lie.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'When we help ourselves, we find moments of happiness. When we help others, we find lasting fulfillment.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'Some see risk as a reason not to try. Some see it as an obstacle to overcome. The risk is the same; to try or not depends on your perspective.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'Achievement happens when we pursue and attain what we want. Success comes when we are in clear pursuit of Why we want it.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'No matter when or where, always bring your ‘A’ game, because you never know when it will open doors for you.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'As the Zen Buddhist saying goes, how you do anything is how you do everything.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'Always plan for the fact that no plan ever goes according to plan.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'Knowledge is understanding based on what has been studied and learned. Wisdom is understanding based on what has been felt and experienced.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'Confidence is believing in yourself. Arrogance is telling others youre better than they are. Confidence inspires. Arrogance destroys.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'When people are financially invested, they want a return. When people are emotionally invested, they want to contribute.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'Dream big. Start small. But most of all, start.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'A leader’s job is not to do the work for others; it’s to help others figure out how to do it themselves, to get things done and to succeed beyond what they thought possible.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'What good is an idea if it remains an idea? Try. Experiment. Iterate. Fail. Try again. Change the world.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'There is a difference between listening and waiting for your turn to speak.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'You can easily judge the character of a man by how he treats those who can do nothing for him.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'More information is always better than less. When people know the reason things are happening, even if it’s bad news, they can adjust their expectations and react accordingly. Keeping people in the dark only serves to stir negative emotions.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'Value is not determined by those who set the price. Value is determined by those who choose to pay it.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'If you want to feel happy, do something for yourself. If you want to feel fulfilled, do something for someone else.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'If no one ever broke the rules, then we’d never advance.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'If you want to achieve anything in this world, you have to get used to the idea that not everyone will like you.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'One of the greatest things you can do is give your time and energy – things you will never get back.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'There are only two ways to influence human behavior: you can manipulate it or you can inspire it.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'Don’t show up to prove. Show up to improve.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'Leadership requires two things: a vision of the world that does not yet exist and the ability to communicate it.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'Children are better off having a parent who works into the night in a job they love than a parent who works shorter hours but comes home unhappy.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'Regardless of WHAT we do in our lives, our WHY—our driving purpose, cause or belief—never changes.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'Self confidence is the ability to exercise restraint in the face of disrespect and still show respect in response.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'The goal is not to be perfect by the end, the goal is to be better today.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'The only way to ‘find out if it will work out’ is to do it.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'Panic causes tunnel vision. Calm acceptance of danger allows us to more easily assess the situation and see the options.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'Integrity is when our words and deeds are consistent with our intentions.',
            ],
            [
                'author' => 'Simon Sinek',
                'content' => 'The primary ingredient for progress is optimism. The unwavering belief that something can be better drives the human race forward.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'The ultimate measure of a man is not where he stands in moments of comfort and convenience, but where he stands at times of challenge.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'Everything you need to be great is already inside you. Stop waiting for someone or something to light your fire. YOU have the match.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'Success means having the courage, the determination, and the will to become the person you believe you were meant to be.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'There is a one thing that 99 percent of “failures” and “successful” folks have in common — they all hate doing the same things. The difference is successful people do them anyway.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'Your past doesn’t define you, it prepares you.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'Hang out with those who have a common future, not a common past.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'Don’t follow your dreams. Chase them down with aggressive pursuit.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'When it comes to breaking old habits and starting new ones, remember to be patient with yourself. You’ve got to expect it’s going to take time and effort before you see lasting results.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'Once-dominant empires have failed for this very reason. People get to a certain level of success and get too comfortable.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'Consistency is the key to achieving and maintaining momentum.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'There’s nothing wrong with ordinary. I just prefer to shoot for extraordinary.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'Choices are at the root of every one of your results. Each choice starts a behavior that over time becomes a habit.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'It’s not enough to choose to be successful. You have to dig deeper than that to find your core motivation, to activate your superpower. Your why-power.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'Everyone is affected by three kinds of influences: input (what you feed your mind), associations (the people with whom you spend time), and environment (your surroundings).',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'You alone are responsible for what you do, don’t do, or how you respond to what’s done to you.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'Don’t wish it were easier; wish you were better.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'In essence, you make your choices, and then your choices make you.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'You will never change your life until you change something you do daily. The secret of your success is found in your daily routine.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'Your biggest challenge isn’t that you’ve intentionally been making bad choices. Your biggest challenge is that you’ve been sleepwalking through your choices.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'When you define your goals, you give your brain something new to look for and focus on.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'If you are not making the progress that you would like to make and are capable of making, it is simply because your goals are not clearly defined.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'You get started by taking one small step, one action at a time.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'If you really want to maintain a good habit, make sure you pay attention to it at least once a day, and you’re far more likely to succeed.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'The first step toward change is awareness. If you want to get from where you are to where you want to be, you have to start by becoming aware of the choices that lead you away from your desired destination.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'Motivation without action, leads to self-delusion.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'Garden your head – pull out the weeds of excuses and plant the seeds of greatness.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'Start your day with why, then get on with your what.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'It’s not what you learn or what you know; it’s what you do with what you know and learn.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'Falling is part of getting better.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'Fear is not real. It’s an illusion, a phenomenon that resides entirely within your own brain.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'The activities that you are most afraid of are the activities that can cause a breakthrough in your success.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'Unsuccessful people carry their goals around in their head like marbles rattling around in a can, and we say a goal that is not in writing is merely a fantasy.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'Risk means acting without certainty.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'Don’t envy the achiever, BE the achiever.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'What controls your attention, controls your life.',
            ],
            [
                'author' => 'Darren Hardy',
                'content' => 'Critics are bitter dreamers gone scared. Empathize and ignore.',
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
