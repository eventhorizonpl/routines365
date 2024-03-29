<?php

declare(strict_types=1);

namespace App\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class ProfilePhoneVerificationCodeFormModel
{
    #[Assert\GreaterThanOrEqual(100000)]
    #[Assert\LessThanOrEqual(999999)]
    #[Assert\NotBlank]
    #[Assert\Type('int')]
    public int $phoneVerificationCode;
}
