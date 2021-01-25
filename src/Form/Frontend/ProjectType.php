<?php

declare(strict_types=1);

namespace App\Form\Frontend;

use App\Entity\Project;
use App\Form\Type\YesNoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
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
            $builder->add('isCompleted', YesNoType::class, [
                'help' => 'Determines whether you completed the project.',
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
