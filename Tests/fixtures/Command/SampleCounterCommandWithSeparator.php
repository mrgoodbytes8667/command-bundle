<?php


namespace Bytes\CommandBundle\Tests\fixtures\Command;


use Bytes\CommandBundle\Command\BaseCommand;
use Bytes\CommandBundle\Command\Traits\CounterTableHelperTrait;
use Symfony\Component\Console\Attribute\AsCommand;

/**
 *
 */
#[AsCommand('app:sample')]
class SampleCounterCommandWithSeparator extends BaseCommand
{
    use CounterTableHelperTrait;

    /**
     * @return int
     */
    protected function executeCommand(): int
    {
        $this->createTable(['Column A', 'Column B']);
        $this->addTableSeparator();
        $this->renderTable(forceRender: true);

        $this->io->comment('Done');
        return static::SUCCESS;
    }
}
