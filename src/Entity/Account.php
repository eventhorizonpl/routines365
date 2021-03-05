<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AccountRepository;
use App\Resource\ConfigResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AccountRepository::class)
 */
class Account
{
    use Traits\IdTrait;
    use Traits\UuidTrait;
    use Traits\BlameableTrait;
    use Traits\TimestampableTrait;

    public const TOPUP_REFERRER_ACCOUNT_MULTIPLIER = 0.05;

    /**
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="account", orphanRemoval=true, targetEntity=AccountOperation::class)
     * @ORM\OrderBy({"id" = "DESC"})
     */
    private Collection $accountOperations;

    /**
     * @ORM\OneToMany(fetch="EXTRA_LAZY", mappedBy="account", targetEntity=User::class)
     */
    private Collection $users;

    /**
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\NotBlank()
     * @Assert\Type("int")
     * @Groups({"gdpr"})
     * @ORM\Column(type="integer")
     */
    private int $availableNotifications;

    /**
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\NotBlank()
     * @Assert\Type("int")
     * @Groups({"gdpr"})
     * @ORM\Column(type="integer")
     */
    private int $availableSmsNotifications;

    public function __construct()
    {
        $this->accountOperations = new ArrayCollection();
        $this->availableNotifications = 0;
        $this->availableSmsNotifications = 0;
        $this->users = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getUuid();
    }

    public function addAccountOperation(AccountOperation $accountOperation): self
    {
        if (false === $this->accountOperations->contains($accountOperation)) {
            $this->accountOperations->add($accountOperation);
            $accountOperation->setAccount($this);
        }

        return $this;
    }

    public function getAccountOperations(): Collection
    {
        return $this->accountOperations->filter(function (AccountOperation $accountOperation) {
            return null === $accountOperation->getDeletedAt();
        });
    }

    public function getAccountOperationsAll(): Collection
    {
        return $this->accountOperations;
    }

    public function removeAccountOperation(AccountOperation $accountOperation): self
    {
        if (true === $this->accountOperations->contains($accountOperation)) {
            $this->accountOperations->removeElement($accountOperation);
        }

        return $this;
    }

    public function canDepositNotifications(int $notifications): bool
    {
        if (ConfigResource::ACCOUNT_AVAILABLE_NOTIFICATIONS_LIMIT > ($this->getAvailableNotifications() + $notifications)) {
            return true;
        } else {
            return false;
        }
    }

    public function depositNotifications(int $notifications): self
    {
        $this->setAvailableNotifications($this->getAvailableNotifications() + $notifications);

        return $this;
    }

    public function getAvailableNotifications(): int
    {
        return $this->availableNotifications;
    }

    public function setAvailableNotifications(int $availableNotifications): self
    {
        $this->availableNotifications = $availableNotifications;

        return $this;
    }

    public function canWithdrawNotifications(int $notifications): bool
    {
        if (0 <= ($this->getAvailableNotifications() - $notifications)) {
            return true;
        } else {
            return false;
        }
    }

    public function withdrawNotifications(int $notifications): self
    {
        $this->setAvailableNotifications($this->getAvailableNotifications() - $notifications);

        return $this;
    }

    public function canDepositSmsNotifications(int $smsNotifications): bool
    {
        if (ConfigResource::ACCOUNT_AVAILABLE_SMS_NOTIFICATIONS_LIMIT > ($this->getAvailableSmsNotifications() + $smsNotifications)) {
            return true;
        } else {
            return false;
        }
    }

    public function depositSmsNotifications(int $smsNotifications): self
    {
        $this->setAvailableSmsNotifications($this->getAvailableSmsNotifications() + $smsNotifications);

        return $this;
    }

    public function getAvailableSmsNotifications(): int
    {
        return $this->availableSmsNotifications;
    }

    public function setAvailableSmsNotifications(int $availableSmsNotifications): self
    {
        $this->availableSmsNotifications = $availableSmsNotifications;

        return $this;
    }

    public function canWithdrawSmsNotifications(int $smsNotifications): bool
    {
        if (0 <= ($this->getAvailableSmsNotifications() - $smsNotifications)) {
            return true;
        } else {
            return false;
        }
    }

    public function withdrawSmsNotifications(int $smsNotifications): self
    {
        $this->setAvailableSmsNotifications($this->getAvailableSmsNotifications() - $smsNotifications);

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
