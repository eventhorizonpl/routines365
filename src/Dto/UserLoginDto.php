<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\User;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

class UserLoginDto extends BaseResponseDto
{
    /**
     * @OA\Property(property="data", ref=@Model(type=User::class, groups={"login"}))
     */
    #[Groups(['login'])]
    public User $data;

    public function __construct(int $code, User $data, ?string $status = null)
    {
        parent::__construct($code, $status);

        $this->data = $data;
    }
}
