<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\CompletedRoutine;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

class CompletedRoutineListDto extends BaseResponseDto
{
    /**
     * @OA\Property(type="array", @OA\Items(ref=@Model(type=CompletedRoutine::class, groups={"list"})))
     */
    #[Groups(['list'])]
    public array $data;

    public function __construct(int $code, array $data, ?string $status = null)
    {
        parent::__construct($code, $status);

        $this->data = $data;
    }
}
