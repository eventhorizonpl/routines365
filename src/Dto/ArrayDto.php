<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

abstract class ArrayDto extends BaseResponseDto
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type("array")
     * @Groups({"list", "show"})
     */
    public array $data;

    public function __construct(int $code, array $data, ?string $status = null)
    {
        parent::__construct($code, $status);

        $this->data = $data;
    }
}
