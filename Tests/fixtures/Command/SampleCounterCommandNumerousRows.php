<?php


namespace Bytes\CommandBundle\Tests\fixtures\Command;


use Bytes\CommandBundle\Command\BaseCommand;
use Bytes\CommandBundle\Command\Traits\CounterTableHelperTrait;
use Bytes\CommandBundle\Command\Traits\ProgressBarHelperTrait;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\String\ByteString;

/**
 *
 */
#[AsCommand('app:sample')]
class SampleCounterCommandNumerousRows extends BaseCommand
{
    use CounterTableHelperTrait, ProgressBarHelperTrait;

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
