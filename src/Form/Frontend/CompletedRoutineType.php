<?php

declare(strict_types=1);

namespace App\Form\Frontend;

use App\Entity\CompletedRoutine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompletedRoutineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('comment', TextareaType::class, [
                'required' => false,
            ])
            ->add('date', DateTimeType::class, [
                'date_widget' => 'single_text',
                'input' => 'datetime_immutable',
            ])
            ->add('minutesDevoted')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CompletedRoutine::class,
        ]);
    }
}
