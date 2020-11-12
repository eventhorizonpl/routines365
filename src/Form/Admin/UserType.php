<?php

declare(strict_types=1);

namespace App\Form\Admin;

use App\Entity\User;
use App\Form\Type\YesNoType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends BaseUserType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('isEnabled', YesNoType::class)
            ->add('isVerified', YesNoType::class)
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
