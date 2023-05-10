<?php


namespace Bytes\CommandBundle\Tests\fixtures\Command;


use Bytes\CommandBundle\Command\BaseCommand;
use Symfony\Component\Console\Attribute\AsCommand;

/**
 *
 */
#[AsCommand('app:sample')]
class SampleSuccessOnlyNeedsOutputWithoutVarCommand extends BaseCommand
{
    /**
     * @return int
     */
    protected function executeCommand(): int
    {
        $this->io->comment('Done');
        if (empty($this->output)) {
            return static::FAILURE;
        } else {
            return static::SUCCESS;
        }
    }
}
