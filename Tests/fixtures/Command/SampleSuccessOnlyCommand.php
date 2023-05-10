<?php


namespace Bytes\CommandBundle\Tests\fixtures\Command;


use Bytes\CommandBundle\Command\BaseCommand;
use Symfony\Component\Console\Attribute\AsCommand;

/**
 * Class SampleSuccessOnlyCommand
 * @package Bytes\CommandBundle\Tests\fixtures\Command
 */
#[AsCommand('app:sample')]
class SampleSuccessOnlyCommand extends BaseCommand
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
