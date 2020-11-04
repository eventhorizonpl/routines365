<?php

namespace App\Entity;

use App\Repository\SavedEmailRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SavedEmailRepository::class)
 * @ORM\Table(indexes={@ORM\Index(name="email_idx", columns={"email"}), @ORM\Index(name="type_idx", columns={"type"})})
 */
class SavedEmail
{
    use Traits\IdTrait;
    use Traits\UuidTrait;
    use Traits\BlameableTrait;
    use Traits\TimestampableTrait;

    public const TYPE_INVITATION = 'invitation';
    public const TYPE_MOTIVATIONAL = 'motivational';

    /**
     * @Assert\Valid
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="savedEmails", targetEntity=User::class)
     */
    private User $user;

    /**
     * @Assert\Email()
     * @Assert\Length(
     *   max = 180
     * )
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @ORM\Column(length=180, type="string")
     */
    private string $email;

    /**
     * @Assert\Choice(callback="getTypeValidationChoices")
     * @Assert\Length(
     *   max = 16
     * )
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @ORM\Column(length=16, type="string")
     */
    private string $type;

    public function __construct()
    {
        $this->email = '';
        $this->type = self::TYPE_INVITATION;
    }

    public function __toString(): string
    {
        return $this->getUuid();
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public static function getTypeFormChoices(): array
    {
        return [
            self::TYPE_INVITATION => self::TYPE_INVITATION,
            self::TYPE_MOTIVATIONAL => self::TYPE_MOTIVATIONAL,
        ];
    }

    public static function getTypeValidationChoices(): array
    {
        return array_keys(self::getTypeFormChoices());
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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
