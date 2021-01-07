<?php

declare(strict_types=1);

namespace App\Form\Admin;

use App\Entity\Question;
use App\Form\Type\YesNoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('position')
            ->add('type', ChoiceType::class, [
                'choices' => Question::getTypeFormChoices(),
            ])
            ->add('isEnabled', YesNoType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
            'validation_groups' => ['form'],
        ]);
    }
}
