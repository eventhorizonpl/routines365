<?php

declare(strict_types=1);

namespace App\Form\Frontend;

use App\Entity\Routine;
use Symfony\Component\Form\Extension\Core\Type\{CheckboxType, ChoiceType, TextareaType};
use Symfony\Component\Form\{AbstractType, FormBuilderInterface};
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
            ->add('isEnabled', CheckboxType::class, [
                'help' => 'The system does not send reminders for a routine that is not enabled.',
                'label_attr' => [
                    'class' => 'switch-custom',
                ],
                'required' => false,
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
