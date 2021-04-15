<?php

declare(strict_types=1);

namespace App\Form\Frontend;

use App\Form\Model\InvitationEmailFormModel;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\{AbstractType, FormBuilderInterface};
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvitationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InvitationEmailFormModel::class,
        ]);
    }
}
