<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use ApiPlatform\Core\Annotation\{ApiProperty, ApiResource};
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource]
trait IdTrait
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     * @ORM\Id()
     */
    #[ApiProperty(identifier: false)]
    #[Assert\Type('int', groups: ['system'])]
    protected ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
