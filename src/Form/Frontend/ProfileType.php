<?php

namespace App\Form\Frontend;

use App\Config;
use App\Entity\Profile;
use App\Form\BaseProfileType;
use App\Form\Type\YesNoType;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('showMotivationalMessages', YesNoType::class, [
                'help' => 'Indicates if you want to see a motivational messages in user interface.',
                'required' => true,
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

        if (true === Config::INVITATIONS_ENABLED) {
            $builder
                ->add('firstName', TextType::class, [
                    'help' => 'First name is required for sending invitations.',
                    'required' => false,
                ])
                ->add('lastName', TextType::class, [
                    'help' => 'Last name is required for sending invitations.',
                    'required' => false,
                ])
            ;
        }
    }
}
