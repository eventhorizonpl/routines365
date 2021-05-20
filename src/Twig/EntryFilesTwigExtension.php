<?php

declare(strict_types=1);

namespace App\Twig;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\WebpackEncoreBundle\Asset\EntrypointLookupInterface;
use Twig\Extension\AbstractExtension;
use Twig\{TwigFilter, TwigFunction};

class EntryFilesTwigExtension extends AbstractExtension
{
    public function __construct(
        private EntrypointLookupInterface $entrypointLookup,
        private ParameterBagInterface $parameterBag
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('encore_entry_css_source', [$this, 'getEncoreEntryCssSource']),
        ];
    }

    public function getEncoreEntryCssSource(string $entryName): string
    {
        $files = $this->entrypointLookup->getCssFiles($entryName);

        $source = '';

        foreach ($files as $file) {
            $source .= file_get_contents($this->parameterBag->get('kernel.project_dir').'/public/'.$file);
        }

        return $source;
    }
}
