<?php

declare(strict_types=1);

namespace App\Form\Frontend;

use App\Entity\Profile;
use App\Form\BaseProfileType;
use App\Resource\ConfigResource;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
            ->add('sendWeeklyMonthlyStatistics', CheckboxType::class, [
                'help' => 'Determines whether you want to receive weekly/monthly/yearly statistics emails.',
                'label_attr' => [
                    'class' => 'switch-custom',
                ],
                'required' => true,
            ])
            ->add('showMotivationalMessages', CheckboxType::class, [
                'help' => 'Determines whether you want to see motivational messages in the user interface.',
                'label_attr' => [
                    'class' => 'switch-custom',
                ],
                'required' => true,
            ])
            ->add('theme', ChoiceType::class, [
                'choices' => Profile::getThemeFormChoices(),
                'help' => 'Determines what user interface theme you want to use.',
                'required' => true,
            ])
            ->add('timeZone', TimezoneType::class, [
                'help' => 'The system requires time zone information for proper work of reminders.',
                'required' => true,
            ])
        ;

        if (true === ConfigResource::NOTIFICATION_SMS_ENABLED) {
            $builder
                ->add('phone', PhoneNumberType::class, [
                    'help' => 'The system requires a mobile phone number for the proper work of SMS reminders.',
                    'label' => 'Phone (optional)',
                    'required' => false,
                ])
            ;
        }

        if ((true === ConfigResource::INVITATIONS_ENABLED) ||
            (true === ConfigResource::MOTIVATE_A_FRIEND_ENABLED)
        ) {
            $builder
                ->add('firstName', TextType::class, [
                    'help' => 'The system requires the first name for sending invitations and motivational messages to friends.',
                    'label' => 'First name (optional)',
                    'required' => false,
                ])
                ->add('lastName', TextType::class, [
                    'help' => 'The system requires the last name for sending invitations and motivational messages to friends.',
                    'label' => 'Last name (optional)',
                    'required' => false,
                ])
            ;
        }
    }
}
