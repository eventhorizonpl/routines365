<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\Extension\Core\Type\{ChoiceType, TextareaType};
use Symfony\Component\Form\{AbstractType, FormBuilderInterface};
use Symfony\Component\OptionsResolver\OptionsResolver;

class BaseContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                'help' => 'Content of the contact message.',
            ])
            ->add('title', null, [
                'help' => 'Title of the contact message.',
            ])
            ->add('type', ChoiceType::class, [
                'choices' => Contact::getTypeFormChoices(),
                'help' => 'Type of the contact message.',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
            'validation_groups' => ['form'],
        ]);
    }
}
