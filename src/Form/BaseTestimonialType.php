<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Testimonial;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\{AbstractType, FormBuilderInterface};
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class BaseTestimonialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                'help' => 'Content of the testimonial.',
            ])
            ->add('signature', null, [
                'help' => 'Signature of the testimonial. You do not need to provide your full name. Your initials or nickname will be also good.',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Testimonial::class,
            'validation_groups' => ['form'],
        ]);
    }
}
