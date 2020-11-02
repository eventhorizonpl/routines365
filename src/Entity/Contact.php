<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 * @ORM\Table(indexes={@ORM\Index(name="type_idx", columns={"type"}), @ORM\Index(name="status_idx", columns={"status"})})
 */
class Contact
{
    use Traits\IdTrait;
    use Traits\UuidTrait;
    use Traits\BlameableTrait;
    use Traits\TimestampableTrait;

    public const STATUS_CLOSED = 'closed';
    public const STATUS_ON_HOLD = 'on_hold';
    public const STATUS_OPEN = 'open';
    public const STATUS_PENDING = 'pending';
    public const STATUS_SOLVED = 'solved';
    public const STATUS_SPAM = 'spam';
    public const TYPE_FEATURE_IDEA = 'feature_idea';
    public const TYPE_QUESTION = 'question';

    /**
     * @Assert\Valid
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\ManyToOne(fetch="EXTRA_LAZY", inversedBy="contacts", targetEntity=User::class)
     */
    private User $user;

    /**
     * @Assert\Length(
     *   max = 2048
     * )
     * @Assert\Type("string")
     * @ORM\Column(length=2048, nullable=true, type="string")
     */
    private ?string $comment;

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
     * @Assert\Choice(callback="getStatusValidationChoices")
     * @Assert\Length(
     *   max = 8
     * )
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @ORM\Column(length=8, type="string")
     */
    private string $status;

    /**
     * @Assert\Length(
     *   max = 255
     * )
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @ORM\Column(type="string")
     */
    private string $title;

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
        $this->comment = '';
        $this->content = '';
        $this->status = self::STATUS_OPEN;
        $this->title = '';
        $this->type = self::TYPE_QUESTION;
    }

    public function __toString(): string
    {
        return $this->getUuid();
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment = null): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public static function getStatusFormChoices(): array
    {
        return [
            self::STATUS_CLOSED => self::STATUS_CLOSED,
            self::STATUS_ON_HOLD => self::STATUS_ON_HOLD,
            self::STATUS_OPEN => self::STATUS_OPEN,
            self::STATUS_PENDING => self::STATUS_PENDING,
            self::STATUS_SOLVED => self::STATUS_SOLVED,
            self::STATUS_SPAM => self::STATUS_SPAM,
        ];
    }

    public static function getStatusValidationChoices(): array
    {
        return array_keys(self::getStatusFormChoices());
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public static function getTypeFormChoices(): array
    {
        return [
            self::TYPE_FEATURE_IDEA => self::TYPE_FEATURE_IDEA,
            self::TYPE_QUESTION => self::TYPE_QUESTION,
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
