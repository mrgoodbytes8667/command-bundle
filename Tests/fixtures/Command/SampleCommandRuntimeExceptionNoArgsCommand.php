<?php


namespace Bytes\CommandBundle\Tests\fixtures\Command;


use Bytes\CommandBundle\Command\BaseCommand;
use Bytes\CommandBundle\Exception\CommandRuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;

/**
 *
 */
#[AsCommand('app:sample')]
class SampleCommandRuntimeExceptionNoArgsCommand extends BaseCommand
{
    /**
     * @return int
     */
    protected function executeCommand(): int
    {
        throw new CommandRuntimeException();
    }
}