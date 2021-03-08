<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use Symfony\Component\Validator\Constraints as Assert;

trait IdTrait
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     * @ORM\Id()
     */
    #[Assert\Type('int', groups: ['system'])]
    protected ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
