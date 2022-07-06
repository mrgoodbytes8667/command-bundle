<?php


namespace Bytes\CommandBundle\Tests\fixtures\Command;


use Bytes\CommandBundle\Command\BaseCommand;
use Bytes\CommandBundle\Command\Traits\CounterTableHelperTrait;
use Bytes\CommandBundle\Command\Traits\ProgressBarHelperTrait;
use Symfony\Component\Console\Helper\TableCellStyle;
use Symfony\Component\String\ByteString;

/**
 *
 */
class SampleCounterCommandNumerousRows extends BaseCommand
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
        $this->createTable(['Column A', 'Column B'], 'Header', 'row');
        foreach (range(1, 1234) as $index) {
            $this->addTableRow(['A', ByteString::fromRandom()]);
        }
        $this->renderTable(forceRender: true);

        $this->io->comment('Done');
        return static::SUCCESS;
    }
}