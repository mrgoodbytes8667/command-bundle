<?php


namespace Bytes\CommandBundle\Tests\fixtures\Command;


use Bytes\CommandBundle\Command\BaseCommand;
use Symfony\Component\Console\Attribute\AsCommand;

/**
 * Class SampleFailureOnlyCommand
 * @package Bytes\CommandBundle\Tests\fixtures\Command
 */
#[AsCommand('app:sample')]
class SampleFailureOnlyCommand extends BaseCommand
{
    /**
     * @return int
     */
    protected function executeCommand(): int
    {
        $this->io->error('Done');
        return static::FAILURE;
    }
}
