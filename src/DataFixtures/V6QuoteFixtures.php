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
            [
                'author' => 'T. Harv Eker',
                'content' => 'If you want to change the fruit, you have to change the roots. If you want to change the visible, you have to change the invisible first.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'If you are willing to do only what’s easy, life will be hard. But if you are willing to do what’s hard, life will be easy.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'When you are complaining, you become a living, breathing crap magnet.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'If you want to move to a new level in your life, you must break through your comfort zone and practice doing things that are not comfortable.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'If you want to make a permanent change, stop focusing on the size of your problems and start focusing on the size of you.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'Rich people play the money game to win. Poor people play the money game to not lose.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'You need to recognize that your entire life is in your head. It’s the way you think. It’s the software system for your life computer, and if you want to change your life, it will have to start with the way you think. Choose your thoughts carefully.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'Never try to pull someone up who doesn’t want it…they’ll just pull you down.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'You would worry a lot less about what people think of you if you realized how little they do.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'How you do anything is how you do everything.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'The biggest obstacle to wealth is fear. People are afraid to think big, but if you think small, you’ll only achieve small things.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'For the rich, it’s not about getting more stuff. It’s about having the freedom to make almost any decision you want.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'Thoughts lead to feelings. Feelings lead to actions. Actions leads to results.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'If you want to fly with the eagles, don’t swim with the ducks!',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'Money will only make you more of what you already are.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'Money is a result. Wealth is a result. Health is a result. Your weight is a result. We live in a world of cause and effect.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'The first element of change is awareness. You can’t change something unless you know it exits.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'Rich people believe: I create my life. Poor people believe: Life happens to me.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'Rich people constantly learn and grow. Poor people think they already know.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'Where attention goes, energy flows.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'Practice being in the present. Do what you’re doing 100%.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'Action is the bridge between the inner world and outer world.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'Successful people have fear, successful people have doubts, and successful people have worries. They just don’t let these feelings stop them.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'Nothing has meaning except the meaning you give it.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'What you focus on expands, focus on the positive.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'Part of your mission in life then must be to share your gifts with as many people as possible. That means being willing to play big.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'The single biggest difference between financial success and financial failure is how well you manage your money. It’s simple: to master money, you must manage money.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'Never have a ceiling on your income.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'The mark of true wealth is determined by how much one can give away.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => '20% of your activities produce 80% of your results.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'Remember, your motto is, if they can do it, I can do it.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'Rich people take advice from people who are richer than they are. Poor people take advice from their friends, who are just as broke as they are.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'Rich people are willing to act in spite of fear. Poor people let fear stop them.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'Rich people admire other rich and successful people. Poor people resent rich and successful people.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'Every master was once a disaster.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'Your income can only grow to the extent that you do.',
            ],
            [
                'author' => 'T. Harv Eker',
                'content' => 'Becoming rich isn’t as much about getting rich financially as about whom you become, in character and mind, to get rich.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'Gratitude is the single most important ingredient to living a successful and fulfilled life.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'Decide what you want, believe you can have it, believe you deserve it and believe it’s possible for you.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'Everything you want is on the other side of fear.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'It’s a universal principle that you get more of what you think about, talk about, and feel strongly about.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'Vague goals produce vague results.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'If you can tune into your purpose and really align with it, setting goals so that your vision is an expression of that purpose, then life flows much more easily.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'To change bad habits, we must study the habits of successful role models.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'Practice random acts of kindness and senseless acts of beauty.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'I generally find that comparison is the fast track to unhappiness.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'Clarify your purpose. What is the why behind everything you do?. When we know this in life or design it is very empowering and the path is clear.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'When you think you can’t revisit a previous triumph.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'I believe people should live full lives and not settle for anything less.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'You only have control over three things in your life. The thoughts you think, the images you visualise, and the action you take.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'To achieve major success in life, you must accept 100% responsibility for your life and results. Nothing less will do.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'If it ain’t fun, don’t do it.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'People who don’t have goals, work for people who do.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'When you have inspired thought, you have to trust it and you have to act on it.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'You either create or allow everything that happens to you.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'Good or bad, habits always deliver results.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'Believing in yourself is a choice. It’s an attitude you develop over time.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'One individual can begin a movement that turns the tide of history.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'Taking the first step is the difference between actually pursuing your passion and just dreaming about it.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'There’s a four letter word you must use when you get rejected….next.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'I worked from 10pm until 1am every night for a year to write the first ‘Chicken Soup For The Soul’ book.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'Most everything that you want is just outside your comfort zone.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'If you are going to be successful in creating the life of your dreams, you have first have to believe what you want is possible and you are capable of making it happen.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'You must take personal responsibility. You cannot change circumstances, the seasons, or the wind, but you can change yourself.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'Everything you want is out there waiting for you to ask. Everything you want also wants you. But you have to take action to get it.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'If you are clear about your goals and take several steps in the right direction everyday, eventually you will succeed. So decide what it is you want, write it down, review it constantly, and each day do something that moves you toward those goals.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'I believe that people make their own luck by great preparation and good strategy.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'Know your priorities and identify the five powerful action steps that you intend to take to move your initiatives forward each day.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'There are essentially two things that will make you wise, the books you read and the people you meet.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'People who ask confidently get more than those who are hesitant and uncertain. When you’ve figured out what you want to ask for, do it with certainty, boldness and confidence.',
            ],
            [
                'author' => 'Jack Canfield',
                'content' => 'You have the power to achieve greatness and create anything and everything you want in life, but you have to take action.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'I was homeless but I wasn’t hopeless. I knew a better day was coming.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'Don’t ever let someone tell you, you can’t do something. Not even me.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'You got a dream you got to protect it.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'People can’t do something themselves, they want to tell you you can’t do it.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'The secret to success: find something you love to do so much, you can’t wait for the sun to rise to do it all over again.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'The world is your oyster. It’s up to you to find the pearls.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'It can be done but you have to make it happen.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'If you believe you can do it, you will.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'Do something that makes you happy and makes you feel good about yourself.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'You want something, go get it. Period.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'There is no plan B for passion.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'Baby steps count, as long as you are going forward. You add them all up, and one day you look back and you’ll be surprised.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'Start where you are.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'It’s okay to fail; it’s not okay to quit.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'Others may question your credentials, your papers, your degrees. Others may look for all kinds of ways to diminish your worth. But what is inside you no one can take from you or tarnish.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'Claim ownership of your dreams.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'If you don’t take the necessary steps to make them happen, dreams are just mirages that mess with your head.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'I am strong because I’ve been weak. I am fearless because I’ve been afraid. I am wise because I’ve been foolish.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'Walk the walk and go forward all the time.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'You can only depend on yourself. The cavalry ain’t coming.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'You have to be bold.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'Every finish line is the beginning of a new race.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'The most inspiring leaders are not those who do their job but those who pursue a calling.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'I hold one thing dearer than all else: my commitment to my son.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'Ready or not, tell yourself to jump.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'Strong people stand up for themselves, the strongest people stand up for others.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'This part of my life, this little part is called happiness.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'Do something that you love.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'Your struggle is not an excuse, it’s your ammunition.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'Always, always pursue happiness.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'One of the things young people always ask me about is what is the secret to success. The secret is there is no secret. It’s the basics. Blocking and tackling.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => '(The movie) is the story of my life, but it’s not about me. It’s about anybody who ever dreamed big and had someone tell them, ‘No, you can’t do it.’ You can.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'Make your vision larger than yourself.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'Then again, what seems like nothing in the eyes of the world, when properly valued and put to use, can be among the greatest riches.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'The balance in your life is more important than the balance in your checking account.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'Without that sense of self, no amount of paper, no pedigree, and no credentials can make you legit. No matter what, you have to feel legit inside first.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'As busy as I am wherever I am, I try to get out and walk the streets, to remember how far I’ve come and appreciate every baby step of the way.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'It’s your responsibility to pursue what matters.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'Still a dreamer, yet more of a realist than ever before, I knew this was my time to sail. On the horizon I saw the shining future, as before. The difference now was that I felt the wind at my back. I was ready.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'Do something that makes you feel your work is significant and meaningful.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'No matter how much money is involved or no matter how easy it is for you to do, if you’re not happy, you are nothing more than a slave to your talent and money.',
            ],
            [
                'author' => 'Chris Gardner',
                'content' => 'Wealth can also be that attitude of gratitude with which we remind ourselves every day to count our blessings.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'In the real world, the smartest people are people who make mistakes and learn. In school, the smartest people don’t make mistakes.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'It’s not what you say out of your mouth that determines your life, it’s what you whisper to yourself that has the most power!',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'It’s more important to grow your income than cut your expenses. It’s more important to grow your spirit that cut your dreams.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'The most successful people in life are the ones who ask questions. They’re always learning. They’re always growing. They’re always pushing.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Don’t be addicted to money. Work to learn. don’t work for money. Work for knowledge.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'It’s easier to stand on the sidelines, criticize, and say why you shouldn’t do something. The sidelines are crowded. Get in the game.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'The trouble with school is they give you the answer, then they give you the exam. That’s not life.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Complaining about your current position in life is worthless. Have a spine and do something about it instead.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'The fear of being different prevents most people from seeking new ways to solve their problems.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Winners are not afraid of losing. But losers are. Failure is part of the process of success. People who avoid failure also avoid success.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Successful people ask questions. They seek new teachers. They’re always learning.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'If you want to be rich, you need to develop your vision. You must be standing on the edge of time gazing into the future.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'If you’re still doing what mommy and daddy said for you to do (go to school, get a job, and save money), you’re losing.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Often, the more money you make the more money you spend; that’s why more money doesn’t make you rich – assets make you rich.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'The most life destroying word of all is the word tomorrow.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'The size of your success is measured by the strength of your desire; the size of your dream; and how you handle disappointment along the way.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'I’d rather welcome change than cling to the past.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'The most successful people are mavericks who aren’t afraid to ask why, especially when everyone thinks it’s obvious.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Hoping drains your energy. Action creates energy.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'The more a person seeks security, the more that person gives up control over his life.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Everyone can tell you the risk. An entrepreneur can see the reward.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'A plan is a bridge to your dreams. Your job is to make the plan or bridge real, so that your dreams will become real. If all you do is stand on the side of the bank and dream of the other side, your dreams will forever be just dreams.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'You’ll often find that it’s not mom or dad, husband or wife, or the kids that’s stopping you. It’s you. Get out of your own way.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'The only difference between a rich person and poor person is how they use their time.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Your choices decide your fate. Take the time to make the right ones. If you make a mistake, that’s fine; learn from it & don’t make it again.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Money is really just an idea.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Talk is cheap. Learn to listen with your eyes. Actions do speak louder than words. Watch what a person does more than what he says.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'The moment you make passive income and portfolio income a part of your life, your life will change. Those words will become flesh.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'You will make some mistakes but, if you learn from those mistakes, those mistakes will become wisdom and wisdom is essential to becoming wealthy.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'If you realize that you’re the problem, then you can change yourself, learn something and grow wiser. Don’t blame other people for your problems.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Workers work hard enough to not be fired, and owners pay just enough so that workers won’t quit.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'As I said, I wish I could say it was easy. It wasn’t, but it wasn’t hard either. But without a strong reason or purpose, anything in life is hard.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'The single most powerful asset we all have is our mind. If it is trained well, it can create enormous wealth in what seems to be an instant.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Find the game where you can win, and then commit your life to playing it; and play to win.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'One of the great things about being willing to try new things and make mistakes is that making mistakes keeps you humble. People who are humble learn more than people who are arrogant.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Intelligence solves problems and produces money. Money without financial intelligence is money soon gone.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Start small and dream big.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Emotions are what make us human. Make us real. The word ’emotion’ stands for energy in motion. Be truthful about your emotions, and use your mind and emotions in your favor, not against yourself.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'You’re only poor if you give up. The most important thing is that you did something. Most people only talk and dream of getting rich. You’ve done something.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'If you want to be financially-free, you need to become a different person than you are today and let go of whatever has held you back in the past.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'The philosophy of the rich and the poor is this: the rich invest their money and spend what is left. The poor spend their money and invest what is left.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Sight is what you see with your eyes, vision is what you see with your mind.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'In school we learn that mistakes are bad, and we are punished for making them. Yet, if you look at the way humans are designed to learn, we learn by making mistakes. We learn to walk by falling down. If we never fell down, we would never walk.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Never say you cannot afford something. That is a poor man’s attitude. Ask HOW to afford it.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'F.O.C.U.S – Follow One Course Until Successful',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Your future is created by what you do today, not tomorrow.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'The more I risk being rejected, the better my chances are of being accepted.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'One of the most stupid things to do is to pretend you are smart. When you pretend to be smart, you are at the height of stupidity.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Find out where you are at, where you are going and build a plan to get there.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Most people want everyone else in the world to change themselves. Let me tell you, it’s easier to change yourself than everyone else.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'People who dream small dreams continue to live as small people.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'The richest people in the world build networks; everyone else is trained to look for work.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'There are those who make things happen, there are those who watch things happen and there are those who say ‘what happened?’',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Skills make you rich, not theories.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'When you come to the boundaries of what you know, it is time to make some mistakes.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'People without financial knowledge, who take advice from financial experts are like lemmings simply following their leader. They race for the cliff and leap into the ocean of financial uncertainty, hoping to swim to the other side.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'The ability to sell is the number one skill in business. If you cannot sell, don’t bother thinking about becoming a business owner.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Too many people are too lazy to think. Instead of learning something new, they think the same thought day in day out.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Education is cheap; experience is expensive.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'There are no mistakes in life, just learning opportunities.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'The love of money is not the root of all evil. The lack of money is the root of all evil.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'We all have tremendous potential, and we all are blessed with gifts. Yet, the one thing that holds all of us back is some degree of self-doubt. It is not so much the lack of technical information that holds us back, but more the lack of self-confidence.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'When you are forced to think, you expand your mental capacity. When you expand your mental capacity, your wealth increases.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Making mistakes isn’t enough to become great. You must also admit the mistake, and then learn how to turn that mistake into an advantage.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'In today’s rapidly changing world, the people who are not taking risk are the risk takers.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Tomorrows only exist in the minds of dreamers and losers.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Excuses cost a dime and that’s why the poor could afford a lot of it.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'People need to wake up and realize that life doesn’t wait for you. If you want something, get up and go after it.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'If you want to be rich, simply serve more people.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'When people are lame, they love to blame.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Inside each of us is a David and a Goliath.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'It is easy to stay the same but it is not easy to change. Most people choose to stay the same all their lives.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'It does not take money to make money.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Face your fears and doubts, and new worlds will open to you.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'A mistake is a signal that it is time to learn something new, something you didn’t know before.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'There are no bad business and investment opportunities, but there are bad entrepreneurs and investors.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'A winning strategy must include losing.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'If you want to go somewhere, it is best to find someone who has already been there.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Success is a poor teacher. We learn the most about ourselves when we fail, so don’t be afraid of failing. Failing is part of the process of success. You cannot have success without failure.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'The wealthy buy luxuries last, while the poor and middle-class tend to buy luxuries first. Why? Emotional discipline.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'To be a successful business owner and investor, you have to be emotionally neutral to winning and losing. Winning and losing are just part of the game.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'The problem with having a job is that it gets in the way of getting rich.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'When times are bad is when the real entrepreneurs emerge.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Sometimes you win, sometimes you learn.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'You get one life. Live it in a way that it inspires someone.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'The biggest challenge you have is to challenge your own self doubt and your laziness. It is your self doubt and your laziness that defines and limit who you are.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'When I started my last business, I didn’t receive a paycheck for 13 months. The average person can’t handle that pressure.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Getting rich begins with the right mindset, the right words and the right plan.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Sometimes, what is right for you at the beginning of your life is not the right thing for you at the end of your life.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Business is like a wheel barrow. Nothing happens until you start pushing.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Starting a business is like jumping out of an airplane without a parachute. In mid air, the entrepreneur begins building a parachute and hopes it opens before hitting the ground.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Business and investing are team sports.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'If you want to be rich the rule of thumb is to teach others how to be rich.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'The hardest part of change is going through the unknown.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Financial struggle is often the direct result of people working all their lives for someone else.',
            ],
            [
                'author' => 'Robert Kiyosaki',
                'content' => 'Being an entrepreneur is simply going from one mistake to the next. You must have the fortitude to continue on.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Pain is temporary. It may last for a minute, or an hour or a day, or even a year. But eventually, it will subside. And something else takes its place. If I quit, however, it will last forever.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Sometimes it ain’t about being the most talented. Sometimes it ain’t about being the smartest. Sometimes it’s not even about working the hardest. Sometimes it’s about consistency! Consistency!',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'The most important thing is this: To be able at any moment, to sacrifice what you are, for what you will become!',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'I’m intoxicated on success!',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Everybody has a dream, but not everybody has a grind.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'A setback is a setup for a comeback.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'There is nothing wrong with dreaming big dreams, just know that all roads that lead to success have to pass through Hardwork Boulevard at some point.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Winners focus on winning. Losers focus on winners.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Only those who risk going too far, can possibly find out how far one can go.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'I’m not the smartest. But you will not out work me! I wake up every morning at 3 o’clock!',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Most of you don’t want success as much as you want to sleep!',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'I’ve got a dream that’s worth more than my sleep.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'God has a purpose for your pain, a reason for your struggles and a reward for your faithfulness. Don’t give up.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Success is not for the weak and uncommitted… Sometimes it’s gonna hurt!',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'An eagle uses the storm to reach unimaginable heights.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Stop the blame game. Stop! Stop looking out the window and look in the mirror!',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Avoid being your own enemy.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Like for real, you can start from the bottom, and by the grace of God, work your way all the way up to the top man.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'You can’t cheat the grind, it knows hows much you’ve invested, it won’t give you nothing you haven’t worked for.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'The difference between those who succeed and fail: not taking advantage of opportunities.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Things change for the better when we take responsibility for our own thoughts, decisions and actions.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Don’t cry to quit! You already in pain, you already hurt! Get a reward from it!',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Both desire and imagination are stored in the mind of the individual and when stretched, both have the potential to position a person for greatness.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Apply the ABC’s of success to your life. Ask, Believe and Claim It.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'I’ve been trying to tell y’all, its’s not your circumstances or situation, that determines if you gonna be successful or not. I’ve been telling you it’s your mindset! It’s the way you see it. It’s the way you think it right!',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'I started studying. I wasn’t watching the game no more. I wanted to study what was in Michael Jordan. I’m like “What’s in Michael Jordan? Michael Jordan got something in him?”',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'You know school ain’t my first love, but we gotta get in here and do it so that young people can know that for real it’s past possible, there’s absolutely nothing that we can’t accomplish.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'The problem is, you get more excited talking about it than you do when you actually doing it!',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Look in the mirror, that’s your competition.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'No alarm clock needed, my passion wakes me.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'I dare you to take a little pain. I dare you!',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Desire and imagination have the potential to position a person for greatness.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Everybody wants to be a beast, until it’s time to do what real beasts do.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'If you’re going to go to your next level, your values are going to have to change.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Listen to me: You’ll never be successful until I don’t have to give you a dime to do what you do.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Most of you won’t be successful because when you’re studying and you get tired, you quit!',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'I don’t care if you broke, you grew up broke… you grew up rich. You only get 24hrs!',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'I’m exactly where I wanted to be because I realized, I gotta commit my very being to this thing.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Some of you need to give up your cell phone!',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Because the time you spend on your cell phone, could be used for your success. The time you could be using to be successful, you’re using on the cell! And the cell phone is not bringing you nothing but a bill!',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'It’s one thing to talk about your destiny. It’s one thing to dream about your destiny. It’s one thing to look at your destiny. But it’s another thing – it is another thing – to make the decisions. To wake up when you know you supposed to wake up!',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'At some point in life you have to face your fears.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Sleep? “I don’t sleep.” You thought that was it? It goes deeper than going without sleep because you might miss the opportunity to succeed. No, no, no! It’s about No Days Off! No weekends! No Holidays! No Birthdays!',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'It’s realizing that a great dream is not as good as a great memory. The dream can be had by anyone. The memory – must be made.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'This is what I’m saying, take advantage of opportunity, because if you do, doors are going to open up for you.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'When you’re great! You attract great! When you’re average! You attract average.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'It’s about optimal movement. Decisive movement. The most effective movement.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'You ain’t average! But you know what? You’re playing small because it’s easier to be average.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'The competitive edge is not something that… it’s not the top tier management… it’s not something that they give you.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'It’s not who you are that holds you back, it’s who you think you’re not.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Fall in love with the process and the results will come.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'You are the executive director and screenwriter of your life.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Be stronger than your excuses.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Practice doesn’t make perfect. Practice makes permanence!',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Listen to me, even when you lose, it’s OK to lose, but you can never get comfortable with it. You can never be satisfied with losing. When you lose, it’s got to hurt.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Stop sabotaging yourself.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'If it takes a boring Biology class, then I’m taking Biology. If I gotta go through Calculus to make my family get to a level they’ve never been too, then Calculus watch your back! Cause your boy is coming.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'When you get to a place where you don’t go for what you can get, but you go for what you can give, you gonna see your life change tremendously.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Information changes situations.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'We all have the ability to produce greatness in our lives.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'It’s not about where you come from; it’s about heart! You come to a place where, you know, being smart ain’t enough. You gotta have heart.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Some of you have never learned to grow up!',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'I was homeless for two and half years. And the problem with most of you, you’ve never felt any pain before. Y’all spoiled.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'I’m here to tell you, number one, that most of you say you want to be successful, but you don’t want it bad, you just kinda want it.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'You got an opportunity to make a dream become a reality – and when you do, you just got to take advantage of it.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'I’m that guy that comes in your high school and tells you, you can make it happen! Greatness is upon you! You better act like it!',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'My greatest asset is I was homeless. So, I can’t feel a whole lot of pain. I’ve already been alone. There’s not a whole of hurt I can feel, on a little paper, on a little test.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'At the end of pain is success.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Stop being average. You’re not even good. You were born to be great.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Success is never on discount! Greatness is never on sale! Greatness is never half off! It’s all or nothing! It’s all day, every day! Greatness is never on discount!',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Stop whining, start grinding.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'What you envision in your mind, how you see yourself, and how you envision the world around you is of great importance because those things become your focus.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'I use pain to push me to greatness.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Don’t make a habit out of choosing what feels good over what’s actually good for you.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'The only way to get out of mediocrity is to keep shooting for excellence.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Don’t think about what can happen in a month. Don’t think about what can happen in a year. Just focus on the 24 hours in front of you and do what you can to get closer to where you want to be.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'If you can look up, you can get up.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'I wanted to surround myself with the kind of people who could help me turn my life around; people whom I could rub up against like iron and be sharpened.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Your relationships will either make you or break you and there is no such thing as a neutral relationship. People either inspire you to greatness or pull you down in the gutter, it’s that simple. No one fails alone, and no one succeeds alone.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Done is better than perfect if perfect ain’t done.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'I do not take constructive criticism from people who have never constructed anything.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Success, meaningful success, begins when we take ownership and actively take responsibility for our part in the shortcomings of our life.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'You can’t sleep. Broke people sleep. You got to be willing to sacrifice sleep, if you sleep you may miss the opportunity to be successful.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'You can get through this. You are bigger than your pain, don’t give up, don’t give in.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'I learned that a real friendship is not about what you can get, but what you can give. Real friendship is about making sacrifices and investing in people to help them improve their lives.',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'Can you honestly say the environment(s) you are in will yield the kind of harvest you are expecting?',
            ],
            [
                'author' => 'Eric Thomas',
                'content' => 'It’s not easy, but it’s simple.',
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
