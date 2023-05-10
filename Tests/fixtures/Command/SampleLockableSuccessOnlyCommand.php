<?php


namespace Bytes\CommandBundle\Tests\fixtures\Command;


use Bytes\CommandBundle\Command\BaseCommand;
use Bytes\CommandBundle\Command\Interfaces\LockableCommandInterface;
use Bytes\CommandBundle\Command\Traits\LockableCommandTrait;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('app:sample')]
class SampleLockableSuccessOnlyCommand extends BaseCommand implements LockableCommandInterface
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
