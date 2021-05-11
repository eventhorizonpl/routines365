<?php

declare(strict_types=1);

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\MaintenanceBundle\Drivers\DriverFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Lock\Store\PdoStore;
use Symfony\Component\Lock\{Lock, LockFactory};

abstract class BaseLockableCommand extends Command
{
    private ?Lock $lock;
    private PdoStore $store;

    public function __construct(
        private DriverFactory $driverFactory,
        protected EntityManagerInterface $entityManager
    ) {
        $this->lock = null;
        $this->store = new PdoStore($entityManager->getConnection());

        parent::__construct();
    }

    public function lock(string $name = null, bool $blocking = false): bool
    {
        if (null !== $this->lock) {
            throw new LogicException('A lock is already in place.');
        }

        $this->lock = (new LockFactory($this->store))->createLock($name ?: $this->getName());
        if (!$this->lock->acquire($blocking)) {
            $this->lock = null;

            return false;
        }

        return true;
    }

    public function release(): void
    {
        if ($this->lock) {
            $this->lock->release();
            $this->lock = null;
        }
    }

    public function hasMaintenanceLock(): bool
    {
        if (true === $this->driverFactory->getDriver()->isExists()) {
            return true;
        }

        return false;
    }
}
