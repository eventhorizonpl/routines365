<?php

namespace App\Form\Frontend;

use App\Form\Security\ChangePasswordFormType as BaseChangePasswordFormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;

class ChangePasswordFormType extends BaseChangePasswordFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('oldPassword', PasswordType::class, [
                'mapped' => false,
            ])
        ;
    }
}
