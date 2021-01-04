<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Util\PeterkahlLocale;
use Locale;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;
use Twig\Extension\CoreExtension;

class TwigTimeZoneListener
{
    private Environment $environment;
    private Security $security;

    public function __construct(
        Environment $environment,
        Security $security
    ) {
        $this->environment = $environment;
        $this->security = $security;
    }

    public function onKernelControllerArguments(ControllerArgumentsEvent $event)
    {
        if ((null !== $this->security->getUser()) &&
            (null !== $this->security->getUser()->getProfile()) &&
            (null !== $this->security->getUser()->getProfile()->getTimeZone())
        ) {
            $timeZone = $this->security->getUser()->getProfile()->getTimeZone();
            $this->environment->getExtension(CoreExtension::class)->setTimeZone($timeZone);
        }
        if ((null !== $this->security->getUser()) &&
            (null !== $this->security->getUser()->getProfile()) &&
            (null !== $this->security->getUser()->getProfile()->getCountry())
        ) {
            $locale = PeterkahlLocale::country2locale($this->security->getUser()->getProfile()->getCountry());
            $locale = current(explode(',', $locale));
            Locale::setDefault($locale);
        }
    }
}
