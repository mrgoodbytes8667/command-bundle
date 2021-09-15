<?php


namespace Bytes\CommandBundle\Tests\fixtures\Command;


use Bytes\CommandBundle\Command\BaseCommand;
use Bytes\CommandBundle\Exception\CommandRuntimeException;

/**
 *
 */
class SampleCommandRuntimeExceptionMessageReturnSuccessCommand extends BaseCommand
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:sample';

    /**
     * @return int
     */
    protected function executeCommand(): int
    {
        throw new CommandRuntimeException('This is an error', false, static::SUCCESS);
    }
}