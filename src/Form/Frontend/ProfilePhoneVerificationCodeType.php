<?php

declare(strict_types=1);

namespace App\Form\Frontend;

use App\Form\Model\ProfilePhoneVerificationCodeFormModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfilePhoneVerificationCodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('phoneVerificationCode', IntegerType::class, [
                'help' => 'You should receive verification code on your phone number.',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProfilePhoneVerificationCodeFormModel::class,
        ]);
    }
}
