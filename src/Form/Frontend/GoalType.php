<?php

namespace App\Form\Frontend;

use App\Entity\Goal;
use App\Form\Type\YesNoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GoalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $goal = $options['data'];

        $builder
            ->add('description', TextareaType::class, [
                'required' => false,
            ])
            ->add('name')
        ;

        if (null !== $goal->getId()) {
            $builder->add('isCompleted', YesNoType::class);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Goal::class,
        ]);
    }
}
