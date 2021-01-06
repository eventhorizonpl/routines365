<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

abstract class BaseResponseDto
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type("int")
     */
    public int $code;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("string")
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
