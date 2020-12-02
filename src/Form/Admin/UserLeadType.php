<?php

declare(strict_types=1);

namespace App\Form\Admin;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;

class UserLeadType extends BaseUserType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['data'];
        parent::buildForm($builder, $options);

        $builder
            ->add('emailNotifications', IntegerType::class, [
                'data' => 10,
                'mapped' => false,
            ])
            ->add('smsNotifications', IntegerType::class, [
                'data' => 0,
                'mapped' => false,
            ])
            ->remove('plainPassword')
        ;
    }
}
