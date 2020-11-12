<?php

declare(strict_types=1);

namespace App\Form\Admin;

use App\Entity\Contact;
use App\Form\BaseContactType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactType extends BaseContactType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('comment', TextareaType::class, [
                'required' => false,
            ])
            ->add('status', ChoiceType::class, [
                'choices' => Contact::getStatusFormChoices(),
            ])
        ;
    }
}
