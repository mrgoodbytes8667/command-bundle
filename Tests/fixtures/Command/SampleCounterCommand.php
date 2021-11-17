<?php


namespace Bytes\CommandBundle\Tests\fixtures\Command;


use Bytes\CommandBundle\Command\BaseCommand;
use Bytes\CommandBundle\Command\Traits\CounterTableHelperTrait;

/**
 *
 */
class SampleCounterCommand extends BaseCommand
{
    use CounterTableHelperTrait;

    /**
     * @var string
     */
    protected static $defaultName = 'app:sample';

    /**
     * @return int
     */
    protected function executeCommand(): int
    {
        $this->createTable([], 'Header', 'row');
        $this->addTableRow([]);
        $this->addTableRow([]);
        $this->renderTable(true);

        unset($this->table);
        $this->addTableRow([]);
        unset($this->table);
        $this->renderTable();

        $this->io->comment('Done');
        return static::SUCCESS;
    }
}