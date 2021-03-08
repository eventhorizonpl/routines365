<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TestimonialRepository;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TestimonialRepository::class)
 * @ORM\Table(indexes={@ORM\Index(name="status_idx", columns={"status"})})
 */
class Testimonial
{
    use Traits\IdTrait;
    use Traits\UuidTrait;
    use Traits\IsVisibleTrait;
    use Traits\BlameableTrait;
    use Traits\TimestampableTrait;

    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_NEW = 'new';
    public const STATUS_REJECTED = 'rejected';

    /**
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\OneToOne(fetch="EXTRA_LAZY", inversedBy="testimonial", targetEntity=User::class)
     */
    #[Assert\Valid(groups: ['system'])]
    private User $user;

    /**
     * @Groups({"gdpr"})
     * @ORM\Column(length=255, nullable=true, type="string")
     */
    #[Assert\Length(groups: ['form', 'system'], max: 255)]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('string', groups: ['form', 'system'])]
    private ?string $content;

    /**
     * @Groups({"gdpr"})
     * @ORM\Column(length=128, nullable=true, type="string")
     */
    #[Assert\Length(groups: ['form', 'system'], max: 128)]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('string', groups: ['form', 'system'])]
    private ?string $signature;

    /**
     * @ORM\Column(length=8, type="string")
     */
    #[Assert\Choice(callback: 'getStatusValidationChoices', groups: ['system'])]
    #[Assert\Length(groups: ['system'], max: 8)]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('string', groups: ['system'])]
    private string $status;

    public function __construct()
    {
        $this->content = '';
        $this->isVisible = false;
        $this->signature = '';
        $this->status = self::STATUS_NEW;
    }

    public function __toString(): string
    {
        return $this->getUuid();
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getSignature(): string
    {
        return $this->signature;
    }

    public function setSignature(?string $signature): self
    {
        $this->signature = $signature;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public static function getStatusFormChoices(): array
    {
        return [
            self::STATUS_ACCEPTED => self::STATUS_ACCEPTED,
            self::STATUS_NEW => self::STATUS_NEW,
            self::STATUS_REJECTED => self::STATUS_REJECTED,
        ];
    }

    public static function getStatusValidationChoices(): array
    {
        return array_keys(self::getStatusFormChoices());
    }

    public function setStatus(string $status): self
    {
        if (!(in_array($status, self::getStatusValidationChoices()))) {
            throw new InvalidArgumentException('Invalid status');
        }

        $this->status = $status;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
