<?php

namespace App\Form\Frontend;

use App\Entity\Reminder;
use App\Form\Type\YesNoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReminderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('hour', TimeType::class, [
                'input' => 'datetime_immutable',
            ])
            ->add('isEnabled', YesNoType::class)
            ->add('minutesBefore', ChoiceType::class, [
                'choices' => Reminder::getMinutesBeforeFormChoices(),
            ])
            ->add('sendEmail', YesNoType::class)
            ->add('sendSms', YesNoType::class)
            ->add('type', ChoiceType::class, [
                'choices' => Reminder::getTypeFormChoices(),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reminder::class,
        ]);
    }
}
