<?php


namespace Bytes\CommandBundle\Tests\fixtures\Command;


use Bytes\CommandBundle\Command\BaseCommand;
use Bytes\CommandBundle\Command\Traits\CounterTableHelperTrait;
use Bytes\CommandBundle\Command\Traits\ProgressBarHelperTrait;

/**
 *
 */
class SampleCounterCommand extends BaseCommand
{
    use CounterTableHelperTrait, ProgressBarHelperTrait;

    /**
     * @var string
     */
    protected static $defaultName = 'app:sample';

    /**
     * @return int
     */
    protected function executeCommand(): int
    {
        $bar = $this->createVeryVerboseProgressBar();
        $this->createTable([], 'Header', 'row');
        $this->addTableRow([]);
        $bar->advance();
        $this->addTableRow([]);
        $bar->advance();
        $this->finishProgressBar($bar);
        $this->renderTable(true);

        unset($this->table);
        $this->addTableRow([]);
        unset($this->table);
        $this->renderTable();

        $this->io->comment('Done');
        return static::SUCCESS;
    }
}