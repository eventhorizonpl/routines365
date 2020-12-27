<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use Symfony\Component\Validator\Constraints as Assert;

trait IdTrait
{
    /**
     * @Assert\Type("int", groups={"system"})
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     * @ORM\Id()
     */
    protected ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
