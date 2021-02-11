<?php

declare(strict_types=1);

namespace App\Form\Admin;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends BaseUserType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('isEnabled', CheckboxType::class, [
                'label_attr' => [
                    'class' => 'switch-custom',
                ],
            ])
            ->add('isVerified', CheckboxType::class, [
                'label_attr' => [
                    'class' => 'switch-custom',
                ],
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => User::getRolesFormChoices(),
                'expanded' => false,
                'multiple' => true,
            ])
            ->add('type', ChoiceType::class, [
                'choices' => User::getTypeFormChoices(),
                'expanded' => false,
                'multiple' => false,
            ])
        ;
    }
}
