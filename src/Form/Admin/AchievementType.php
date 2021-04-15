<?php

declare(strict_types=1);

namespace App\Form\Admin;

use App\Entity\Achievement;
use Symfony\Component\Form\Extension\Core\Type\{CheckboxType, ChoiceType, TextareaType};
use Symfony\Component\Form\{AbstractType, FormBuilderInterface};
use Symfony\Component\OptionsResolver\OptionsResolver;

class AchievementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description', TextareaType::class, [
                'required' => false,
            ])
            ->add('isEnabled', CheckboxType::class, [
                'label_attr' => [
                    'class' => 'switch-custom',
                ],
                'required' => false,
            ])
            ->add('level')
            ->add('requirement')
            ->add('type', ChoiceType::class, [
                'choices' => Achievement::getTypeFormChoices(),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Achievement::class,
            'validation_groups' => ['form'],
        ]);
    }
}
