<?php


namespace Bytes\CommandBundle\Tests\fixtures\Command;


use Bytes\CommandBundle\Command\BaseCommand;
use Bytes\CommandBundle\Exception\CommandRuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 *
 */
class SampleInteractionCommandRuntimeExceptionMessageCommand extends BaseCommand
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:sample';

    /**
     * Interacts with the user.
     *
     * This method is executed before the InputDefinition is validated.
     * This means that this is the only place where the command can
     * interactively ask for values of missing required arguments.
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        throw new CommandRuntimeException('This is an error', true);
    }


    /**
     * @return int
     */
    protected function executeCommand(): int
    {
        return static::SUCCESS;
    }
}