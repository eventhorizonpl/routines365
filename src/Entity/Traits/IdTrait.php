<?php

namespace App\Entity\Traits;

use Symfony\Component\Validator\Constraints as Assert;

trait IdTrait
{
    /**
     * @Assert\Type("int")
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
