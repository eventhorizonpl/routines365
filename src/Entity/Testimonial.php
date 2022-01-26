<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\TestimonialStatusEnum;
use App\Repository\TestimonialRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TestimonialRepository::class)]
#[ORM\Index(name: 'status_idx', columns: ['status'])]
class Testimonial
{
    use Traits\BlameableTrait;
    use Traits\IdTrait;
    use Traits\IsVisibleTrait;
    use Traits\TimestampableTrait;
    use Traits\UuidTrait;

    #[Assert\Valid(groups: ['system'])]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[ORM\OneToOne(fetch: 'EXTRA_LAZY', inversedBy: 'testimonial', targetEntity: User::class)]
    private User $user;

    #[Assert\Length(groups: ['form', 'system'], max: 255)]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('string', groups: ['form', 'system'])]
    #[Groups(['gdpr'])]
    #[ORM\Column(nullable: true, type: Types::STRING)]
    private ?string $content;

    #[Assert\Length(groups: ['form', 'system'], max: 128)]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('string', groups: ['form', 'system'])]
    #[Groups(['gdpr'])]
    #[ORM\Column(length: 128, nullable: true, type: Types::STRING)]
    private ?string $signature;

    #[Assert\Choice(callback: 'getStatusValidationChoices', groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type(TestimonialStatusEnum::class, groups: ['system'])]
    #[ORM\Column(enumType: TestimonialStatusEnum::class, length: 8, type: Types::STRING)]
    private TestimonialStatusEnum $status;

    public function __construct()
    {
        $this->content = '';
        $this->isVisible = false;
        $this->signature = '';
        $this->status = TestimonialStatusEnum::NEW;
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

    public function getSignature(): ?string
    {
        return $this->signature;
    }

    public function setSignature(?string $signature): self
    {
        $this->signature = $signature;

        return $this;
    }

    public function getStatus(): ?TestimonialStatusEnum
    {
        return $this->status;
    }

    public static function getStatusFormChoices(): array
    {
        return [
            TestimonialStatusEnum::ACCEPTED->value => TestimonialStatusEnum::ACCEPTED->value,
            TestimonialStatusEnum::NEW->value => TestimonialStatusEnum::NEW->value,
            TestimonialStatusEnum::REJECTED->value => TestimonialStatusEnum::REJECTED->value,
        ];
    }

    public static function getStatusValidationChoices(): array
    {
        return [
            TestimonialStatusEnum::ACCEPTED,
            TestimonialStatusEnum::NEW,
            TestimonialStatusEnum::REJECTED,
        ];
    }

    public function setStatus(TestimonialStatusEnum $status): self
    {
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
