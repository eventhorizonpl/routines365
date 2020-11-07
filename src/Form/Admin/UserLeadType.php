<?php

namespace App\Form\Admin;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

class UserLeadType extends BaseUserType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('emailNotifications', IntegerType::class, [
                'mapped' => false,
            ])
            ->add('smsNotifications', IntegerType::class, [
                'mapped' => false,
            ])
        ;
    }
}
