<?php

declare(strict_types=1);

namespace App\Form\Frontend;

use App\Entity\Reminder;
use App\Form\Type\YesNoType;
use App\Resource\ConfigResource;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReminderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $reminder = $options['data'];
        $profile = $reminder->getUser()->getProfile();

        $builder
            ->add('hour', TimeType::class, [
                'help' => 'The time when the routine should start.',
                'input' => 'datetime_immutable',
            ])
            ->add('isEnabled', YesNoType::class, [
                'help' => 'Determines whether the system should send a reminder.',
            ])
            ->add('minutesBefore', ChoiceType::class, [
                'choices' => Reminder::getMinutesBeforeFormChoices(),
                'help' => 'How many minutes before the routine starts system should send a reminder.',
            ])
            ->add('sendEmail', YesNoType::class, [
                'help' => 'Determines whether the system should send a reminder to the email address.',
            ])
            ->add('sendMotivationalMessage', YesNoType::class, [
                'help' => 'Determines whether the system should send motivational messages in reminder.',
            ])
            ->add('type', ChoiceType::class, [
                'choices' => Reminder::getTypeFormChoices(),
                'help' => 'Type of the reminder.',
            ])
        ;

        if (true === ConfigResource::NOTIFICATION_BROWSER_ENABLED) {
            $builder->add('sendToBrowser', YesNoType::class, [
                'disabled' => true,
                'help' => 'Determines whether the system should send a reminder to the web browser.',
            ]);
        }

        if ((true === ConfigResource::NOTIFICATION_SMS_ENABLED) &&
            (in_array($profile->getCountry(), ConfigResource::COUNTRIES_ALLOWED_FOR_SMS))
        ) {
            $builder->add('sendSms', YesNoType::class, [
                'help' => 'Determines whether the system should send a reminder to the phone number.',
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reminder::class,
            'validation_groups' => ['form'],
        ]);
    }
}
