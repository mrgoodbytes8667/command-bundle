<?php


namespace Bytes\CommandBundle\Tests\fixtures\Command;


use Bytes\CommandBundle\Command\BaseCommand;
use DateTime;
use DateTimeInterface;
use Symfony\Component\Console\Attribute\AsCommand;

/**
 * Class SampleTimeCommand
 * @package Bytes\CommandBundle\Tests\fixtures\Command
 */
#[AsCommand('app:sample')]
class SampleTimeCommand extends BaseCommand
{
    /**
     * @var DateTimeInterface
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
     * @return DateTime
     */
    protected function outputCurrentDateTime(string $prepend = '', string $append = '')
    {
        $now = $this->now;
        $now->setTimezone($this->getOutputTimeZone());

        $this->io->note($prepend . $now->format($this->getOutputDateFormat()) . $append);
        return $now;
    }
}
