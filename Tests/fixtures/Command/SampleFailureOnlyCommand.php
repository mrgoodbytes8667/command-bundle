<?php


namespace Bytes\CommandBundle\Tests\fixtures\Command;


use Bytes\CommandBundle\Command\BaseCommand;

/**
 * Class SampleFailureOnlyCommand
 * @package Bytes\CommandBundle\Tests\fixtures\Command
 */
class SampleFailureOnlyCommand extends BaseCommand
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
        $this->io->error('Done');
        return static::FAILURE;
    }
}