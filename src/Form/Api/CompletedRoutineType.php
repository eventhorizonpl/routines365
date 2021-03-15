<?php

declare(strict_types=1);

namespace App\Form\Api;

use App\Form\Frontend\CompletedRoutineType as BaseCompletedRoutineType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompletedRoutineType extends BaseCompletedRoutineType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('routineUuid', null, [
                'mapped' => false,
            ])
            ->remove('date')
            ->add('completedDate', null, [
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'csrf_protection' => false,
            'validation_groups' => ['api'],
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
