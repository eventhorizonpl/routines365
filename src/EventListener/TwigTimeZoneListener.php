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
    public function __construct(
        private Environment $environment,
        private Security $security
    ) {
    }

    public function onKernelControllerArguments(ControllerArgumentsEvent $event): void
    {
        if (null !== $this->security->getUser()?->getProfile()?->getTimeZone()) {
            $timeZone = $this->security->getUser()->getProfile()->getTimeZone();
            $this->environment->getExtension(CoreExtension::class)->setTimeZone($timeZone);
        }
        if (null !== $this->security->getUser()?->getProfile()?->getCountry()) {
            try {
                $country = (new ISO3166())->alpha2($this->security->getUser()->getProfile()->getCountry());
                $alpha3 = $country['alpha3'];
            } catch (Exception $e) {
                $alpha3 = 'USA';
            }

            Locale::setDefault($alpha3);
        }
    }
}
