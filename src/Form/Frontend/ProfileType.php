<?php

declare(strict_types=1);

namespace App\Form\Frontend;

use App\Entity\Profile;
use App\Form\BaseProfileType;
use App\Form\Type\YesNoType;
use App\Resource\ConfigResource;
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
                'help' => 'System requires mobile phone number for proper work of SMS reminders.',
                'required' => false,
            ])
            ->add('sendWeeklyMonthlyStatistics', YesNoType::class, [
                'help' => 'Determines whether you want to receive weekly/monthly/yearly statistics email.',
                'required' => true,
            ])
            ->add('showMotivationalMessages', YesNoType::class, [
                'help' => 'Determines whether you want to see a motivational messages in the user interface.',
                'required' => true,
            ])
            ->add('theme', ChoiceType::class, [
                'choices' => Profile::getThemeFormChoices(),
                'help' => 'Determines what user interface theme you want to use.',
                'required' => true,
            ])
            ->add('timeZone', TimezoneType::class, [
                'help' => 'System requires time zone information for proper work of reminders.',
                'required' => true,
            ])
        ;

        if ((true === ConfigResource::INVITATIONS_ENABLED) ||
            (true === ConfigResource::MOTIVATE_A_FRIEND_ENABLED)
        ) {
            $builder
                ->add('firstName', TextType::class, [
                    'help' => 'System requires first name for sending invitations and motivational messages to friends.',
                    'required' => false,
                ])
                ->add('lastName', TextType::class, [
                    'help' => 'System requires last name for sending invitations and motivational messages to friends.',
                    'required' => false,
                ])
            ;
        }
    }
}
