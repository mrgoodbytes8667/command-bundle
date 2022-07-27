<?php

namespace Bytes\CommandBundle\Command\Traits;

use Bytes\CommandBundle\Command\CommandStyle;
use Symfony\Component\Console\Command\LockableTrait;

/**
 * @property CommandStyle $io
 */
trait LockableCommandTrait
{
    use LockableTrait;

    /**
     * @return bool
     */
    public function isCommandRunning(): bool
    {
        if (!$this->lock()) {
            $this->io->warning('The command is already running in another process.');

            return true;
        }

        return false;
    }

    /**
     * @return void
     */
    public function waitToRunCommand(): void
    {
        $this->lock(null, true);
    }

    /**
     * @return void
     */
    public function releaseCommand(): void
    {
        $this->release();
    }
}
