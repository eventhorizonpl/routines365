<?php

declare(strict_types=1);

namespace App\Form\Frontend;

use App\Entity\Routine;
use App\Form\Type\YesNoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoutineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextareaType::class, [
                'help' => 'Short description of the routine.',
                'label' => 'Description (optional)',
                'required' => false,
            ])
            ->add('isEnabled', YesNoType::class, [
                'help' => 'The system does not send reminders for a routine that is not enabled.',
            ])
            ->add('name', null, [
                'help' => 'Name of the routine. The system uses it in reminders.',
            ])
            ->add('type', ChoiceType::class, [
                'choices' => Routine::getTypeFormChoices(),
                'help' => 'Type of the routine.',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Routine::class,
            'validation_groups' => ['form'],
        ]);
    }
}
