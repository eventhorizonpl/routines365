<?php

declare(strict_types=1);

namespace App\Form\Api;

use App\Form\Frontend\RoutineType as BaseRoutineType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoutineType extends BaseRoutineType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
