<?php


namespace Bytes\CommandBundle\Command;


use Bytes\CommandBundle\Exception\CommandRuntimeException;
use DateTime;
use DateTimeZone;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class BaseCommand
 * @package Bytes\CommandBundle\Command
 */
abstract class BaseCommand extends Command
{
    /**
     * Uses custom CommandStyle instead of SymfonyStyle to show error messages when run as --quiet
     * @var CommandStyle
     */
    protected $io;

    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var bool
     */
    protected $needsOutput = false;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var DateTimeZone
     */
    private $outputTimeZone;

    /**
     * @var string
     */
    private $outputDateFormat = 'm/d/Y g:i:sa T';

    /**
     * 
     */
    const DEFAULT_TIMEZONE = 'America/Chicago';

    /**
     * @param string|null $name
     */
    public function __construct(string $name = null)
    {
        parent::__construct($name);
        $this->setOutputTimeZone();
    }

    /**
     * Executes the current command.
     *
     * This method is not abstract because you can use this class
     * as a concrete class. In this case, instead of defining the
     * execute() method, you set the code to execute by passing
     * a Closure to the setCode() method.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int 0 if everything went fine, or an exit code
     *
     * @throws LogicException When this abstract method is not implemented
     *
     * @see setCode()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io = new CommandStyle($input, $output);
        $this->input = $input;
        if ($this->needsOutput) {
            $this->output = $output;
        }
        try {
            $preExecuteCommand = $this->preExecuteCommand();
            if ($preExecuteCommand !== static::SUCCESS) {
                return $preExecuteCommand;
            }

            $startTime = $this->outputCurrentDateTime('Command starting at ');

            $return = $this->executeCommand();

            if ($return !== static::SUCCESS) {
                $this->io->error(sprintf('Exiting with code %d', $return));
                return $return;
            }

            $return = $this->postExecuteCommand();

            if ($return !== static::SUCCESS) {
                return $return;
            }
        } catch (CommandRuntimeException $exception) {
            if ($exception->shouldDisplayMessage() && !empty($exception->getMessage())) {
                $this->io->error($exception->getMessage());
            }
            $return = $exception->getReturnCode();
        }

        if (!empty($startTime)) {
            $endTime = $this->outputCurrentDateTime('Command ending at ');
            $this->io->note($startTime->diff($endTime)->format('%r%dd %hh %im %ss'));
        }

        return $return;
    }

    /**
     * @return int 0 if everything went fine, or an exit code
     *
     * @throws \Bytes\CommandBundle\Exception\CommandRuntimeException
     */
    protected function preExecuteCommand(): int
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
        $now = new DateTime();
        $now->setTimezone($this->getOutputTimeZone());
        $this->io->note($prepend . $now->format($this->getOutputDateFormat()) . $append);
        return $now;
    }

    /**
     * @return int
     *
     * @throws \Bytes\CommandBundle\Exception\CommandRuntimeException
     */
    abstract protected function executeCommand(): int;

    /**
     * @return int
     *
     * @throws \Bytes\CommandBundle\Exception\CommandRuntimeException
     */
    protected function postExecuteCommand(): int
    {
        return static::SUCCESS;
    }

    /**
     * @return DateTimeZone
     */
    public function getOutputTimeZone(): DateTimeZone
    {
        return $this->outputTimeZone;
    }

    /**
     * @param DateTimeZone|string|null $outputTimeZone
     * @return $this
     */
    public function setOutputTimeZone($outputTimeZone = null): self
    {
        if(empty($outputTimeZone))
        {
            $outputTimeZone = new DateTimeZone(static::DEFAULT_TIMEZONE);
        } elseif (is_string($outputTimeZone)) {
            $outputTimeZone = new DateTimeZone($outputTimeZone);
        } else {
            if (!($outputTimeZone instanceof DateTimeZone)) {
                $outputTimeZone = new DateTimeZone(static::DEFAULT_TIMEZONE);
            }
        }
        $this->outputTimeZone = $outputTimeZone;
        return $this;
    }

    /**
     * @return string
     */
    public function getOutputDateFormat(): string
    {
        return $this->outputDateFormat;
    }

    /**
     * @param string $outputDateFormat
     * @return $this
     */
    public function setOutputDateFormat(string $outputDateFormat): self
    {
        $this->outputDateFormat = $outputDateFormat;
        return $this;
    }
}