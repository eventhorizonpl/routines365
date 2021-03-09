<?php

declare(strict_types=1);

namespace App\Dto;

use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

abstract class BaseResponseDto
{
    /**
     * @OA\Property(type="string")
     */
    #[Groups(['list', 'show'])]
    public int $code;

    /**
     * @OA\Property(type="string")
     */
    #[Groups(['list', 'show'])]
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
