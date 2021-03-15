<?php

declare(strict_types=1);

namespace App\Form\Frontend;

use App\Entity\Reward;
use App\Entity\Routine;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RewardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $reward = $options['data'];

        $builder
            ->add('description', TextareaType::class, [
                'help' => 'Short description of the reward.',
                'label' => 'Description (optional)',
                'required' => false,
            ])
            ->add('name', null, [
                'help' => 'Name of the reward.',
            ])
            ->add('requiredNumberOfCompletions', ChoiceType::class, [
                'choices' => Reward::getRequiredNumberOfCompletionsFormChoices(),
                'help' => 'Required number of completions before the system will award this reward.',
                'required' => true,
            ])
            ->add('type', ChoiceType::class, [
                'choices' => Reward::getTypeFormChoices(),
                'help' => 'Type of the reward.',
                'required' => true,
            ])
        ;

        if (null === $reward->getRoutine()) {
            $user = $reward->getUser();
            $builder->add('routine', EntityType::class, [
                'class' => Routine::class,
                'help' => 'Routine associated with the reward.',
                'label' => 'Routine (optional)',
                'query_builder' => function (EntityRepository $entityRepository) use ($user) {
                    return $entityRepository->createQueryBuilder('r')
                        ->where('r.user = :user')
                        ->andWhere('r.deletedAt IS NULL')
                        ->orderBy('r.name', 'ASC')
                        ->setParameter('user', $user)
                    ;
                },
                'required' => false,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reward::class,
            'validation_groups' => ['form'],
        ]);
    }
}
