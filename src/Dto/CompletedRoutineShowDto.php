<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\CompletedRoutine;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

class CompletedRoutineShowDto extends BaseResponseDto
{
    /**
     * @OA\Property(property="data", ref=@Model(type=CompletedRoutine::class, groups={"show"}))
     */
    #[Groups(['show'])]
    public CompletedRoutine $data;

    public function __construct(int $code, CompletedRoutine $data, ?string $status = null)
    {
        parent::__construct($code, $status);

        $this->data = $data;
    }
}
