<?php

namespace App\Entity;

use App\Repository\AccountRepository;
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
     * @Assert\NotBlank
     * @Assert\Type("int")
     * @ORM\Column(type="integer")
     */
    private int $availableEmailNotifications;

    /**
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
            $note->setAccount($this);
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

    public function withdrawEmailNotifications(int $emailNotifications): self
    {
        $this->setAvailableEmailNotifications($this->getAvailableEmailNotifications() - $emailNotifications);

        return $this;
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