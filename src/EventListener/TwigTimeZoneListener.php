<?php

declare(strict_types=1);

namespace App\EventListener;

use Exception;
use League\ISO3166\ISO3166;
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

    public function onKernelControllerArguments(ControllerArgumentsEvent $event): void
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
            $alpha3 = 'USA';
            try {
                $country = (new ISO3166())->alpha2($this->security->getUser()->getProfile()->getCountry());
                $alpha3 = $country['alpha3'];
            } catch (Exception $e) {
            }

            Locale::setDefault($alpha3);
        }
    }
}
