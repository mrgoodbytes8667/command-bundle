<?php


namespace Bytes\CommandBundle\Tests\fixtures\Command;


use Bytes\CommandBundle\Command\BaseCommand;
use Bytes\CommandBundle\Command\Interfaces\LockableWaitCommandInterface;
use Bytes\CommandBundle\Command\Traits\LockableCommandTrait;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('app:sample')]
class SampleLockableWaitSuccessOnlyCommand extends BaseCommand implements LockableWaitCommandInterface
{
    use LockableCommandTrait;

    /**
     * @return int
     */
    protected function executeCommand(): int
    {
        $this->io->comment('Done');
        return static::SUCCESS;
    }
}
