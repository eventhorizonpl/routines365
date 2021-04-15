<?php

declare(strict_types=1);

namespace App\Form\Admin;

use App\Entity\Questionnaire;
use Symfony\Component\Form\Extension\Core\Type\{CheckboxType, TextareaType};
use Symfony\Component\Form\{AbstractType, FormBuilderInterface};
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionnaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description', TextareaType::class, [
                'required' => false,
            ])
            ->add('isEnabled', CheckboxType::class, [
                'label_attr' => [
                    'class' => 'switch-custom',
                ],
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Questionnaire::class,
            'validation_groups' => ['form'],
        ]);
    }
}
