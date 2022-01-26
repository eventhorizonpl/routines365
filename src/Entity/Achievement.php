<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\AchievementTypeEnum;
use App\Repository\AchievementRepository;
use Doctrine\Common\Collections\{ArrayCollection, Collection};
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AchievementRepository::class)]
#[ORM\Index(name: 'type_idx', columns: ['type'])]
class Achievement
{
    use Traits\BlameableTrait;
    use Traits\IdTrait;
    use Traits\IsEnabledTrait;
    use Traits\TimestampableTrait;
    use Traits\UuidTrait;

    #[ORM\ManyToMany(fetch: 'EXTRA_LAZY', mappedBy: 'achievements', targetEntity: User::class)]
    private Collection $users;

    #[Assert\Length(groups: ['form', 'system'], max: 255)]
    #[Assert\Type('string', groups: ['form', 'system'])]
    #[ORM\Column(nullable: true, type: Types::STRING)]
    private ?string $description;

    #[Assert\GreaterThanOrEqual(1, groups: ['form', 'system'])]
    #[Assert\LessThanOrEqual(10, groups: ['form', 'system'])]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('int', groups: ['form', 'system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $level;

    #[Assert\Length(groups: ['form', 'system'], max: 64)]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('string', groups: ['form', 'system'])]
    #[ORM\Column(length: 64, type: Types::STRING)]
    private ?string $name;

    #[Assert\GreaterThanOrEqual(1, groups: ['form', 'system'])]
    #[Assert\LessThanOrEqual(1000, groups: ['form', 'system'])]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('int', groups: ['form', 'system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $requirement;

    #[Assert\Choice(callback: 'getTypeValidationChoices', groups: ['form', 'system'])]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type(AchievementTypeEnum::class, groups: ['form', 'system'])]
    #[ORM\Column(enumType: AchievementTypeEnum::class, length: 24, type: Types::STRING)]
    private ?AchievementTypeEnum $type;

    public function __construct()
    {
        $this->description = null;
        $this->isEnabled = true;
        $this->level = 1;
        $this->name = '';
        $this->requirement = 1;
        $this->users = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getUuid();
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(?int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getRequirement(): ?int
    {
        return $this->requirement;
    }

    public function setRequirement(?int $requirement): self
    {
        $this->requirement = $requirement;

        return $this;
    }

    public function getType(): ?AchievementTypeEnum
    {
        return $this->type;
    }

    public static function getTypeFormChoices(): array
    {
        return [
            AchievementTypeEnum::COMPLETED_ROUTINE->value => AchievementTypeEnum::COMPLETED_ROUTINE->value,
            AchievementTypeEnum::COMPLETED_GOAL->value => AchievementTypeEnum::COMPLETED_GOAL->value,
            AchievementTypeEnum::COMPLETED_PROJECT->value => AchievementTypeEnum::COMPLETED_PROJECT->value,
            AchievementTypeEnum::CREATED_NOTE->value => AchievementTypeEnum::CREATED_NOTE->value,
        ];
    }

    public static function getTypeValidationChoices(): array
    {
        return [
            AchievementTypeEnum::COMPLETED_ROUTINE,
            AchievementTypeEnum::COMPLETED_GOAL,
            AchievementTypeEnum::COMPLETED_PROJECT,
            AchievementTypeEnum::CREATED_NOTE,
        ];
    }

    public function setType(?AchievementTypeEnum $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function addUser(User $user): self
    {
        if (false === $this->users->contains($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function removeUser(User $user): self
    {
        if (true === $this->users->contains($user)) {
            $this->users->removeElement($user);
        }

        return $this;
    }
}
