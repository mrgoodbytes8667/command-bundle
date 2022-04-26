<?php


namespace Bytes\CommandBundle\Tests\fixtures\Command;


use Bytes\CommandBundle\Command\BaseCommand;
use Bytes\CommandBundle\Command\Traits\CounterTableHelperTrait;

/**
 *
 */
class SampleCounterCommandNoTableRenders extends BaseCommand
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
        $this->createTable(['Column A', 'Column B'], 'Header', 'row');
        $this->renderTable();

        $this->io->comment('Done');
        return static::SUCCESS;
    }
}
