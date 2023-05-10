<?php


namespace Bytes\CommandBundle\Tests\fixtures\Command;


use DateTime;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class SampleFailureInputCommand
 * @package Bytes\CommandBundle\Tests\fixtures\Command
 */
class SampleFailureInputCommand extends SampleTimeCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setDefinition([
                new InputOption('pre', null, InputOption::VALUE_NONE, 'A test option'),
                new InputOption('post', null, InputOption::VALUE_NONE, 'A test option'),
            ]);
    }

    /**
     * @return int 0 if everything went fine, or an exit code
     */
    protected function preExecuteCommand(): int
    {
        $pre = (true === $this->input->getOption('pre'));
        if ($pre) {
            return static::SUCCESS;
        }

        $this->io->error('Missing option --pre');
        return static::FAILURE;
    }

    /**
     * @return int 0 if everything went fine, or an exit code
     */
    protected function postExecuteCommand(): int
    {
        $post = (true === $this->input->getOption('post'));
        if ($post) {
            return static::SUCCESS;
        }

        $this->io->error('Missing option --post');
        return static::FAILURE;
    }

    /**
     * @param string $prepend
     * @param string $append
     * @return DateTime
     */
    protected function outputCurrentDateTime(string $prepend = '', string $append = '')
    {
        return $this->now;
    }
}
