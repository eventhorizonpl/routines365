<?php

namespace App\Form\Frontend;

use App\Entity\Note;
use App\Entity\Routine;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class NoteType extends AbstractType
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $note = $options['data'];

        $builder
            ->add('content', TextareaType::class)
            ->add('title')
        ;

        if (null === $note->getRoutine()) {
            $user = $this->security->getUser();
            $builder->add('routine', EntityType::class, [
                'class' => Routine::class,
                'query_builder' => function (EntityRepository $entityRepository) use ($user) {
                    return $entityRepository->createQueryBuilder('n')
                        ->where('n.user = :user')
                        ->andWhere('n.deletedAt IS NULL')
                        ->orderBy('n.name', 'ASC')
                        ->setParameter('user', $user);
                },
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Note::class,
        ]);
    }
}
