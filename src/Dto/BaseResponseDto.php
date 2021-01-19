<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

abstract class BaseResponseDto
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type("int")
     * @Groups({"list", "show"})
     */
    public int $code;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Groups({"list", "show"})
     */
    public string $status;

    public function __construct(int $code, ?string $status = null)
    {
        $this->code = $code;
        if (null !== $status) {
            $this->status = $status;
        } else {
            $this->status = 'success';
        }
    }
}
