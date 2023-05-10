<?php


namespace Bytes\CommandBundle\Tests\fixtures\Command;


use Bytes\CommandBundle\Command\BaseEntityManagerCommand;
use Symfony\Component\Console\Attribute\AsCommand;

/**
 * Class SampleSuccessOnlyEntityCommand
 * @package Bytes\CommandBundle\Tests\fixtures\Command
 */
#[AsCommand('app:sample')]
class SampleSuccessOnlyEntityCommand extends BaseEntityManagerCommand
{
    /**
     * @return int
     */
    protected function executeCommand(): int
    {
        $this->io->comment('Done');
        return static::SUCCESS;
    }
}
