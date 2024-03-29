<?php

declare(strict_types=1);

namespace App\Form\Frontend;

use App\Entity\{Goal, Project, Routine};
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\{CheckboxType, TextareaType};
use Symfony\Component\Form\{AbstractType, FormBuilderInterface};
use Symfony\Component\OptionsResolver\OptionsResolver;

class GoalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $goal = $options['data'];
        $user = $goal->getUser();

        $builder
            ->add('description', TextareaType::class, [
                'help' => 'Short description of the goal.',
                'label' => 'Description (optional)',
                'required' => false,
            ])
            ->add('name', null, [
                'help' => 'Name of the goal.',
            ])
            ->add('project', EntityType::class, [
                'class' => Project::class,
                'help' => 'Project associated with the goal.',
                'label' => 'Project (optional)',
                'query_builder' => function (EntityRepository $entityRepository) use ($user) {
                    return $entityRepository->createQueryBuilder('p')
                        ->where('p.user = :user')
                        ->andWhere('p.deletedAt IS NULL')
                        ->andWhere('p.isCompleted = :isCompleted')
                        ->orderBy('p.name', 'ASC')
                        ->setParameter('isCompleted', false)
                        ->setParameter('user', $user)
                    ;
                },
                'required' => false,
            ])
            ->add('routine', EntityType::class, [
                'class' => Routine::class,
                'help' => 'Routine associated with the goal.',
                'query_builder' => function (EntityRepository $entityRepository) use ($user) {
                    return $entityRepository->createQueryBuilder('r')
                        ->where('r.user = :user')
                        ->andWhere('r.deletedAt IS NULL')
                        ->orderBy('r.name', 'ASC')
                        ->setParameter('user', $user)
                    ;
                },
                'required' => true,
            ])
        ;

        if (null !== $goal->getId()) {
            $builder->add('isCompleted', CheckboxType::class, [
                'help' => 'Determines whether you achieved the goal.',
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
            'data_class' => Goal::class,
            'validation_groups' => ['form'],
        ]);
    }
}
