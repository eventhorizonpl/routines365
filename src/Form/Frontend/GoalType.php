<?php

declare(strict_types=1);

namespace App\Form\Frontend;

use App\Entity\Goal;
use App\Entity\Project;
use App\Entity\Routine;
use App\Form\Type\YesNoType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GoalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $goal = $options['data'];
        $user = $goal->getUser();

        $builder
            ->add('description', TextareaType::class, [
                'required' => false,
            ])
            ->add('name')
            ->add('project', EntityType::class, [
                'class' => Project::class,
                'query_builder' => function (EntityRepository $entityRepository) use ($user) {
                    return $entityRepository->createQueryBuilder('p')
                        ->where('p.user = :user')
                        ->andWhere('p.deletedAt IS NULL')
                        ->andWhere('p.isCompleted = :isCompleted')
                        ->orderBy('p.name', 'ASC')
                        ->setParameter('isCompleted', false)
                        ->setParameter('user', $user);
                },
                'required' => false,
            ])
            ->add('routine', EntityType::class, [
                'class' => Routine::class,
                'query_builder' => function (EntityRepository $entityRepository) use ($user) {
                    return $entityRepository->createQueryBuilder('r')
                        ->where('r.user = :user')
                        ->andWhere('r.deletedAt IS NULL')
                        ->orderBy('r.name', 'ASC')
                        ->setParameter('user', $user);
                },
                'required' => true,
            ])
        ;

        if (null !== $goal->getId()) {
            $builder->add('isCompleted', YesNoType::class);
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
