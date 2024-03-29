<?php

declare(strict_types=1);

namespace App\Form\Admin;

use App\Entity\Promotion;
use Symfony\Component\Form\Extension\Core\Type\{CheckboxType, ChoiceType, DateTimeType, TextareaType};
use Symfony\Component\Form\{AbstractType, FormBuilderInterface};
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromotionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code')
            ->add('description', TextareaType::class, [
                'required' => false,
            ])
            ->add('notifications')
            ->add('expiresAt', DateTimeType::class, [
                'date_widget' => 'single_text',
                'input' => 'datetime_immutable',
                'required' => false,
            ])
            ->add('isEnabled', CheckboxType::class, [
                'label_attr' => [
                    'class' => 'switch-custom',
                ],
                'required' => false,
            ])
            ->add('name')
            ->add('smsNotifications')
            ->add('type', ChoiceType::class, [
                'choices' => Promotion::getTypeFormChoices(),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Promotion::class,
            'validation_groups' => ['form'],
        ]);
    }
}
