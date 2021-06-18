<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Dto\{NoteCollectionInput, NoteCollectionOutput, NoteItemInput, NoteItemOutput};
use App\Repository\NoteRepository;
use App\Security\Voter\NoteVoter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=NoteRepository::class)
 */
#[ApiResource(
    collectionOperations: [
        'get' => [
            'output' => NoteCollectionOutput::class,
        ],
        'post' => [
            'input' => NoteCollectionInput::class,
            'output' => NoteItemOutput::class,
        ],
    ],
    itemOperations: [
        'delete' => [
            'security' => 'is_granted("'.NoteVoter::DELETE.'", object)',
        ],
        'get' => [
            'output' => NoteItemOutput::class,
            'security' => 'is_granted("'.NoteVoter::VIEW.'", object)',
        ],
        'patch' => [
            'input' => NoteItemInput::class,
            'output' => NoteItemOutput::class,
            'security' => 'is_granted("'.NoteVoter::EDIT.'", object)',
        ],
        'put' => [
            'input' => NoteItemInput::class,
            'output' => NoteItemOutput::class,
            'security' => 'is_granted("'.NoteVoter::EDIT.'", object)',
        ],
    ],
)]
class Note
{
    use Traits\BlameableTrait;
    use Traits\IdTrait;
    use Traits\TimestampableTrait;
    use Traits\UuidTrait;

    public const CONTEXT_DEFAULT = 'default';
    public const CONTEXT_ROUTINE = 'routine';

    /**
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="notes", targetEntity=Routine::class)
     */
    #[Assert\Valid(groups: ['system'])]
    private ?Routine $routine;

    /**
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="notes", targetEntity=User::class)
     */
    #[Assert\Valid(groups: ['system'])]
    private User $user;

    /**
     * @ORM\Column(length=2048, type="string")
     */
    #[Assert\Length(groups: ['form', 'system'], max: 2048)]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('string', groups: ['form', 'system'])]
    #[Groups(['gdpr'])]
    private ?string $content;

    /**
     * @ORM\Column(type="string")
     */
    #[Assert\Length(groups: ['form', 'system'], max: 255)]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('string', groups: ['form', 'system'])]
    #[Groups(['gdpr'])]
    private ?string $title;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
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
