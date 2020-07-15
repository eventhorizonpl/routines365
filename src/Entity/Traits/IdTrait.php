<?php

namespace App\Entity\Traits;

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
