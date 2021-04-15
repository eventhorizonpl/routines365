<?php

declare(strict_types=1);

namespace App\Dto;

class ErrorResponseDto extends BaseResponseDto
{
    public function __construct(int $code, ?string $status = null)
    {
        if (null === $status) {
            $status = 'error';
        }

        parent::__construct($code, $status);
    }
}
