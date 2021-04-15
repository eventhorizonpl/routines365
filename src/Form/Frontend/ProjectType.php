<?php

declare(strict_types=1);

namespace App\Form\Frontend;

use App\Entity\Project;
use Symfony\Component\Form\Extension\Core\Type\{CheckboxType, TextareaType};
use Symfony\Component\Form\{AbstractType, FormBuilderInterface};
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $project = $options['data'];

        $builder
            ->add('description', TextareaType::class, [
                'help' => 'Short description of the project.',
                'label' => 'Description (optional)',
                'required' => false,
            ])
            ->add('name', null, [
                'help' => 'Name of the project.',
            ])
        ;

        if (null !== $project->getId()) {
            $builder->add('isCompleted', CheckboxType::class, [
                'help' => 'Determines whether you completed the project.',
                'label' => 'Is completed (optional)',
                'label_attr' => [
                    'class' => 'switch-custom',
                ],
                'required' => false,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
            'validation_groups' => ['form'],
        ]);
    }
}
