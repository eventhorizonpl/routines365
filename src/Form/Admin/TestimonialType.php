<?php

declare(strict_types=1);

namespace App\Form\Admin;

use App\Entity\Testimonial;
use App\Form\BaseTestimonialType;
use Symfony\Component\Form\Extension\Core\Type\{CheckboxType, ChoiceType};
use Symfony\Component\Form\FormBuilderInterface;

class TestimonialType extends BaseTestimonialType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('isVisible', CheckboxType::class, [
                'label_attr' => [
                    'class' => 'switch-custom',
                ],
                'required' => false,
            ])
            ->add('status', ChoiceType::class, [
                'choices' => Testimonial::getStatusFormChoices(),
            ])
        ;
    }
}
