<?php

declare(strict_types=1);

namespace App\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class SendMotivationalEmailFormModel
{
    #[Assert\Email]
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public string $email;
}
