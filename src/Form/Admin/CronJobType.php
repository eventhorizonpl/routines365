<?php

declare(strict_types=1);

namespace App\Form\Admin;

use App\Form\Type\YesNoType;
use Cron\CronBundle\Entity\CronJob;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CronJobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('command', null, [
                'required' => true,
                'constraints' => [new NotBlank()],
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'constraints' => [new NotBlank()],
            ])
            ->add('name', null, [
                'required' => true,
                'constraints' => [new NotBlank()],
            ])
            ->add('schedule', null, [
                'required' => true,
                'constraints' => [new NotBlank()],
            ])
            ->add('enabled', YesNoType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CronJob::class,
        ]);
    }
}
