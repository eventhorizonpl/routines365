<?php

namespace App\Form\Frontend;

use App\Entity\Profile;
use App\Form\BaseProfileType;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TimezoneType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileType extends BaseProfileType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('phone', PhoneNumberType::class, [
                'help' => 'The phone number is required for proper work of SMS notifications.',
                'required' => false,
            ])
            ->add('theme', ChoiceType::class, [
                'choices' => Profile::getThemeFormChoices(),
                'required' => true,
            ])
            ->add('timeZone', TimezoneType::class, [
                'help' => 'The time zone information is required for proper work of notifications.',
                'required' => true,
            ])
        ;
    }
}
