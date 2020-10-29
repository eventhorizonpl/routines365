<?php

namespace App\Form\Frontend;

use App\Entity\Reminder;
use App\Form\Type\YesNoType;
use App\Resource\ConfigResource;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class ReminderType extends AbstractType
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $profile = $this->security->getUser()->getProfile();

        $builder
            ->add('hour', TimeType::class, [
                'input' => 'datetime_immutable',
            ])
            ->add('isEnabled', YesNoType::class)
            ->add('minutesBefore', ChoiceType::class, [
                'choices' => Reminder::getMinutesBeforeFormChoices(),
            ])
            ->add('sendEmail', YesNoType::class)
            ->add('sendMotivationalMessage', YesNoType::class)
            ->add('type', ChoiceType::class, [
                'choices' => Reminder::getTypeFormChoices(),
            ])
        ;

        if (in_array($profile->getCountry(), ConfigResource::COUNTRIES_ALLOWED_FOR_SMS)) {
            $builder->add('sendSms', YesNoType::class);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reminder::class,
        ]);
    }
}
