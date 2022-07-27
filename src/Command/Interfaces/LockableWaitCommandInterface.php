<?php

namespace Bytes\CommandBundle\Command\Interfaces;


/**
 * Have your BaseCommand implement this interface (and use LockableCommandTrait) to wait for another instance
 * of this command to exit before continuing.
 *
 * @see LockableCommandTrait
 * @see LockableCommandInterface
 */
interface LockableWaitCommandInterface extends LockableCommandInterface
{
    /**
     * @return void
     */
    public function waitToRunCommand(): void;
}
