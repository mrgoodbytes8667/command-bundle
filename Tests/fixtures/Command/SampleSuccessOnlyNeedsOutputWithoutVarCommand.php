<?php


namespace Bytes\CommandBundle\Tests\fixtures\Command;


use Bytes\CommandBundle\Command\BaseCommand;

/**
 *
 */
class SampleSuccessOnlyNeedsOutputWithoutVarCommand extends BaseCommand
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
        if(empty($this->output))
        {
            return static::FAILURE;
        } else {
            return static::SUCCESS;
        }
    }
}