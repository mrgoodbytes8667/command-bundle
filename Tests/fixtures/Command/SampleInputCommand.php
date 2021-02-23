<?php


namespace Bytes\CommandBundle\Tests\fixtures\Command;


use Bytes\CommandBundle\Command\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class SampleInputCommand
 * @package Bytes\CommandBundle\Tests\fixtures\Command
 */
class SampleInputCommand extends BaseCommand
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:sample';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setDefinition([
                new InputOption('test', null, InputOption::VALUE_NONE, 'A test option'),
            ]);
    }

    /**
     * @return int
     */
    protected function executeCommand(): int
    {
        $test = (true === $this->input->getOption('test'));
        if($test) {
            return static::SUCCESS;
        }

        return static::FAILURE;
    }
}