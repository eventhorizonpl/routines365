<?php

declare(strict_types=1);

namespace App\Form\Admin;

use App\Entity\Promotion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromotionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('browserNotifications')
            ->add('code')
            ->add('description', TextareaType::class, [
                'required' => false,
            ])
            ->add('emailNotifications')
            ->add('expiresAt', DateTimeType::class, [
                'date_widget' => 'single_text',
                'input' => 'datetime_immutable',
                'required' => false,
            ])
            ->add('isEnabled', CheckboxType::class, [
                'label_attr' => [
                    'class' => 'switch-custom',
                ],
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
