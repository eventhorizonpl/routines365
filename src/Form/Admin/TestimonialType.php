<?php

declare(strict_types=1);

namespace App\Form\Admin;

use App\Entity\Testimonial;
use App\Form\BaseTestimonialType;
use App\Form\Type\YesNoType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class TestimonialType extends BaseTestimonialType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('isVisible', YesNoType::class)
            ->add('status', ChoiceType::class, [
                'choices' => Testimonial::getStatusFormChoices(),
            ])
        ;
    }
}
