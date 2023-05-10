<?php


namespace Bytes\CommandBundle\Tests\fixtures\Command;


use Bytes\CommandBundle\Command\BaseCommand;
use Bytes\CommandBundle\Exception\CommandRuntimeException;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class SampleSuccessOnlyCommand
 * @package Bytes\CommandBundle\Tests\fixtures\Command
 */
class SampleInputReplacementCommand extends BaseCommand
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
        return static::SUCCESS;
    }

    /**
     *
     */
    protected function configure()
    {
        parent::configure();
        $this
            ->addOption('new', shortcut: 'c', mode: InputOption::VALUE_NONE, description: 'New input that replaces --old')
            ->addOption('old', mode: InputOption::VALUE_NONE, description: 'Old input <fg=red> [deprecated: --new option is used in place of this]</>');
    }

    /**
     * Runs as part of {@see preExecuteCommand()}
     * Used to replace deprecated inputs for easier future deprecation removal
     * @return int Number of inputs replaced (or 0 to silence output)
     *
     * @throws CommandRuntimeException if an error condition occurs
     */
    protected function handleInputReplacements(): int
    {
        if($this->input->getOption('old')) {
            $this->input->setOption('new', $this->input->getOption('old'));
            return 1;
        }

        return 0;
    }


}