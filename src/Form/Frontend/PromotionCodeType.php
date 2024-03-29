<?php

declare(strict_types=1);

namespace App\Form\Frontend;

use App\Form\Model\PromotionCodeFormModel;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\{AbstractType, FormBuilderInterface};
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromotionCodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'Promotion code',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PromotionCodeFormModel::class,
        ]);
    }
}
