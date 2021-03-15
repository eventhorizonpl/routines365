<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Routine;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

class RoutineShowDto extends BaseResponseDto
{
    /**
     * @OA\Property(property="data", ref=@Model(type=Routine::class, groups={"show"}))
     */
    #[Groups(['show'])]
    public Routine $data;

    public function __construct(int $code, Routine $data, ?string $status = null)
    {
        parent::__construct($code, $status);

        $this->data = $data;
    }
}
