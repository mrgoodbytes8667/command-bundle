<?php


namespace Bytes\CommandBundle\Tests\fixtures\Command;


use Bytes\CommandBundle\Command\BaseCommand;

/**
 * Class SampleSuccessOnlyCommand
 * @package Bytes\CommandBundle\Tests\fixtures\Command
 */
class SampleSuccessOnlyCommand extends BaseCommand
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
        $this->io->comment('Done');
        return static::SUCCESS;
    }
}