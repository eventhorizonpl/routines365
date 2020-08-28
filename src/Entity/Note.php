<?php

namespace App\Entity;

use App\Repository\NoteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=NoteRepository::class)
 */
class Note
{
    use Traits\IdTrait;
    use Traits\UuidTrait;
    use Traits\BlameableTrait;
    use Traits\TimestampableTrait;

    /**
     * @Assert\Valid
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="notes", targetEntity=Routine::class)
     */
    private ?Routine $routine;

    /**
     * @Assert\Valid
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="notes", targetEntity=User::class)
     */
    private User $user;

    /**
     * @Assert\Length(
     *   max = 2048
     * )
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @ORM\Column(length=2048, type="string")
     */
    private string $content;

    /**
     * @Assert\Length(
     *   max = 255
     * )
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @ORM\Column(type="string")
     */
    private string $title;

    public function __construct()
    {
        $this->content = '';
        $this->routine = null;
        $this->title = '';
    }

    public function __toString(): string
    {
        return $this->getUuid();
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getRoutine(): ?Routine
    {
        return $this->routine;
    }

    public function setRoutine(Routine $routine): self
    {
        $this->routine = $routine;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
