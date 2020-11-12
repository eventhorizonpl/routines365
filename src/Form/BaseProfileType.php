<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Profile;
use App\Form\Type\YesNoType;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TimezoneType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class BaseProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('phone', PhoneNumberType::class, [
                'required' => false,
            ])
            ->add('showMotivationalMessages', YesNoType::class)
            ->add('theme', ChoiceType::class, [
                'choices' => Profile::getThemeFormChoices(),
                'required' => false,
            ])
            ->add('timeZone', TimezoneType::class, [
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
