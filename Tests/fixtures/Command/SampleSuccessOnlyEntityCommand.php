<?php


namespace Bytes\CommandBundle\Tests\fixtures\Command;


use Bytes\CommandBundle\Command\BaseEntityManagerCommand;

/**
 * Class SampleSuccessOnlyEntityCommand
 * @package Bytes\CommandBundle\Tests\fixtures\Command
 */
class SampleSuccessOnlyEntityCommand extends BaseEntityManagerCommand
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