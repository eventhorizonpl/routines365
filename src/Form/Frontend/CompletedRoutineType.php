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
                'help' => 'Comment about completed routine.',
                'label' => 'Comment (optional)',
                'required' => false,
            ])
            ->add('date', DateTimeType::class, [
                'date_widget' => 'single_text',
                'help' => 'Time of the ending of the routine.',
                'input' => 'datetime_immutable',
            ])
            ->add('minutesDevoted', null, [
                'help' => 'Number of minutes devoted for the routine.',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CompletedRoutine::class,
            'validation_groups' => ['form'],
        ]);
    }
}
