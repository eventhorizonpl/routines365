<?php

namespace App\Form\Admin;

use App\Entity\User;
use App\Form\Type\YesNoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['data'];
        $builder
            ->add('email')
            ->add('roles', ChoiceType::class, [
                'choices' => User::getRolesFormChoices(),
                'expanded' => false,
                'multiple' => true,
            ])
            ->add('isEnabled', YesNoType::class)
            ->add('plainPassword', RepeatedType::class, [
                'invalid_message' => 'The password fields must match.',
                'mapped' => false,
                'required' => (null === $user->getId()) ? true : false,
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Password',
                ],
                'second_options' => [
                    'label' => 'Repeat Password',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
