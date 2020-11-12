<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AccountRepository;
use App\Resource\ConfigResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
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
     * @Assert\Valid
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @ORM\OneToOne(fetch="EXTRA_LAZY", inversedBy="account", targetEntity=User::class)
     */
    private User $user;

    /**
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\NotBlank
     * @Assert\Type("int")
     * @ORM\Column(type="integer")
     */
    private int $availableEmailNotifications;

    /**
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\NotBlank
     * @Assert\Type("int")
     * @ORM\Column(type="integer")
     */
    private int $availableSmsNotifications;

    public function __construct()
    {
        $this->accountOperations = new ArrayCollection();
        $this->availableEmailNotifications = 0;
        $this->availableSmsNotifications = 0;
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

    public function canDepositEmailNotifications(int $emailNotifications): bool
    {
        if (ConfigResource::ACCOUNT_AVAILABLE_EMAIL_NOTIFICATIONS_LIMIT > ($this->getAvailableEmailNotifications() + $emailNotifications)) {
            return true;
        } else {
            return false;
        }
    }

    public function depositEmailNotifications(int $emailNotifications): self
    {
        $this->setAvailableEmailNotifications($this->getAvailableEmailNotifications() + $emailNotifications);

        return $this;
    }

    public function getAvailableEmailNotifications(): int
    {
        return $this->availableEmailNotifications;
    }

    public function setAvailableEmailNotifications(int $availableEmailNotifications): self
    {
        $this->availableEmailNotifications = $availableEmailNotifications;

        return $this;
    }

    public function canWithdrawEmailNotifications(int $emailNotifications): bool
    {
        if (0 <= ($this->getAvailableEmailNotifications() - $emailNotifications)) {
            return true;
        } else {
            return false;
        }
    }

    public function withdrawEmailNotifications(int $emailNotifications): self
    {
        $this->setAvailableEmailNotifications($this->getAvailableEmailNotifications() - $emailNotifications);

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
