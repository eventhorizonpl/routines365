<?php

declare(strict_types=1);

namespace App\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class InvitationEmailFormModel
{
    /**
     * @Assert\Email()
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    public $email;
}
