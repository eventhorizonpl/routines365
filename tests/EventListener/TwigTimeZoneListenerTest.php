<?php

declare(strict_types=1);

namespace App\Tests\EventListener;

use App\EventListener\TwigTimeZoneListener;
use App\Faker\UserFaker;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

final class TwigTimeZoneListenerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?Environment $environment;
    /**
     * @inject
     */
    private ?Security $security;
    /**
     * @inject
     */
    private ?TwigTimeZoneListener $twigTimeZoneListener;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        unset(
            $this->environment,
            $this->security,
            $this->twigTimeZoneListener,
            $this->userFaker
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $twigTimeZoneListener = new TwigTimeZoneListener($this->environment, $this->security);

        $this->assertInstanceOf(TwigTimeZoneListener::class, $twigTimeZoneListener);
    }

    public function testOnKernelControllerArguments(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $user->getProfile()->setTimeZone('Europe/Warsaw');

        $httpKernel = $this->getMockBuilder(HttpKernel::class)
            ->disableOriginalConstructor()
            ->getMock();
        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();
        $security = $this->createStub(Security::class);
        $security->method('getUser')
             ->willReturn($user);

        $controllerArgumentsEvent = new ControllerArgumentsEvent($httpKernel, 'App\Entity\AccountOperation::getTypeFormChoices', [], $request, 1);

        $twigTimeZoneListener = new TwigTimeZoneListener($this->environment, $security);

        $this->assertInstanceOf(TwigTimeZoneListener::class, $twigTimeZoneListener);
        $this->assertNull($twigTimeZoneListener->onKernelControllerArguments($controllerArgumentsEvent));
    }

    public function testOnKernelControllerArgumentsCatch(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $user->getProfile()->setCountry('QAZ');
        $user->getProfile()->setTimeZone('Europe/Warsaw');

        $httpKernel = $this->getMockBuilder(HttpKernel::class)
            ->disableOriginalConstructor()
            ->getMock();
        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();
        $security = $this->createStub(Security::class);
        $security->method('getUser')
             ->willReturn($user);

        $controllerArgumentsEvent = new ControllerArgumentsEvent($httpKernel, 'App\Entity\AccountOperation::getTypeFormChoices', [], $request, 1);

        $twigTimeZoneListener = new TwigTimeZoneListener($this->environment, $security);

        $this->assertInstanceOf(TwigTimeZoneListener::class, $twigTimeZoneListener);
        $this->assertNull($twigTimeZoneListener->onKernelControllerArguments($controllerArgumentsEvent));
    }
}
