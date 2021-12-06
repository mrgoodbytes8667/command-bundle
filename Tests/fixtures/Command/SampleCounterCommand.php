<?php


namespace Bytes\CommandBundle\Tests\fixtures\Command;


use Bytes\CommandBundle\Command\BaseCommand;
use Bytes\CommandBundle\Command\Traits\CounterTableHelperTrait;
use Bytes\CommandBundle\Command\Traits\ProgressBarHelperTrait;
use Symfony\Component\Console\Helper\TableCellStyle;

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
        $this->createTable(['A', 'B'], 'Header', 'row');
        $this->addTableRow(['A', 'B']);
        $bar->advance();
        $this->addTableRow(['A', 'B'], ['style' => new TableCellStyle([
            'align' => 'center',
            'fg' => 'red',
            'bg' => 'green',
        ])]);
        $bar->advance();
        $this->finishProgressBar($bar);
        $this->renderTable(true);

        unset($this->table);
        $this->addTableRow(['A', 'B']);
        unset($this->table);
        $this->renderTable();

        $this->io->comment('Done');
        return static::SUCCESS;
    }
}