<?php


namespace Bytes\CommandBundle\Tests\fixtures\Command;


use Bytes\CommandBundle\Command\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class SampleTimeCommand
 * @package Bytes\CommandBundle\Tests\fixtures\Command
 */
class SampleTimeCommand extends BaseCommand
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:sample';

    /**
     * @var \DateTime
     */
    public $now;

    /**
     * @return int
     */
    protected function executeCommand(): int
    {
        return static::SUCCESS;
    }

    /**
     * @param string $prepend
     * @param string $append
     * @return \DateTime
     */
    protected function outputCurrentDateTime(string $prepend = '', string $append = '')
    {
        $now = $this->now;
        $now->setTimezone($this->getOutputTimeZone());
        $this->io->note($prepend . $now->format($this->getOutputDateFormat()) . $append);
        return $now;
    }
}