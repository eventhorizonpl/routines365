<?php

declare(strict_types=1);

namespace App\Form\Frontend;

use App\Entity\{Note, Routine};
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\{AbstractType, FormBuilderInterface};
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $note = $options['data'];

        $builder
            ->add('content', TextareaType::class, [
                'help' => 'Content of the note.',
            ])
            ->add('title', null, [
                'help' => 'Title of the note.',
            ])
        ;

        if (null === $note->getRoutine()) {
            $user = $note->getUser();
            $builder->add('routine', EntityType::class, [
                'class' => Routine::class,
                'help' => 'Routine associated with the note.',
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
            'data_class' => Note::class,
            'validation_groups' => ['form'],
        ]);
    }
}
