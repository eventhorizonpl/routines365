<?php

declare(strict_types=1);

namespace App\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class PromotionCodeFormModel
{
    #[Assert\Length(max: 64)]
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public string $code;
}
