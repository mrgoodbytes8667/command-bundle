<?php


namespace Bytes\CommandBundle\Tests\fixtures\Command;


use Bytes\CommandBundle\Command\BaseCommand;
use Bytes\CommandBundle\Command\Interfaces\LockableWaitCommandInterface;
use Bytes\CommandBundle\Command\Traits\LockableCommandTrait;

class SampleLockableWaitSuccessOnlyCommand extends BaseCommand implements LockableWaitCommandInterface
{
    use LockableCommandTrait;

    /**
     * @var string
     */
    protected static $defaultName = 'app:sample';

    /**
     * @return int
     */
    protected function executeCommand(): int
    {
        $this->io->comment('Done');
        return static::SUCCESS;
    }
}
