<?php

namespace Bytes\CommandBundle\Command\Interfaces;

use Bytes\CommandBundle\Command\Traits\LockableCommandTrait;

/**
 * Have your BaseCommand implement this interface (and use LockableCommandTrait) to gracefully exit if another instance
 * of this command is already running.
 *
 * @see LockableCommandTrait
 * @see LockableWaitCommandInterface
 */
interface LockableCommandInterface
{
    /**
     * @return bool
     */
    public function isCommandRunning(): bool;

    /**
     * @return void
     */
    public function releaseCommand(): void;
}
