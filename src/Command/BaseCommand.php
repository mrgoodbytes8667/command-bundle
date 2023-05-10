<?php


namespace Bytes\CommandBundle\Command;


use Bytes\CommandBundle\Command\Interfaces\LockableCommandInterface;
use Bytes\CommandBundle\Command\Interfaces\LockableWaitCommandInterface;
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
     * @var bool|null
     * @deprecated since 1.2.2, this variable is unnecessary. Output will always be set.
     */
    protected $needsOutput = null;

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
        if(!is_null($this->needsOutput))
        {
            trigger_deprecation('mrgoodbytes8667/command-bundle', '1.2.2', 'The "$needsOutput" variable is deprecated. Output will always be set regardless of value and the variable declaration should be removed.');
        }
    }

    /**
     * Runs the command.
     *
     * The code to execute is either defined directly with the
     * setCode() method or by overriding the execute() method
     * in a sub-class.
     *
     * @return int The command exit code
     *
     * @throws \Exception When binding input fails. Bypass this by calling {@link ignoreValidationErrors()}.
     *
     * @see setCode()
     * @see execute()
     */
    public function run(InputInterface $input, OutputInterface $output): int
    {
        $this->io = new CommandStyle($input, $output);
        $this->input = $input;
        $this->output = $output;

        try {
            return parent::run($input, $output);
        } catch (CommandRuntimeException $exception) {
            if ($exception->shouldDisplayMessage() && !empty($exception->getMessage())) {
                $this->io->error($exception->getMessage());
            }
            return $exception->getReturnCode();
        }
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
        try {
            if (!$this->canCommandRun()) {
                return static::SUCCESS;
            }
            $preExecuteCommand = $this->preExecuteCommand();
            if ($preExecuteCommand !== static::SUCCESS) {
                return $preExecuteCommand;
            }

            $startTime = $this->outputCurrentDateTime('Command starting at ');

            $return = $this->executeCommand();

            if (is_subclass_of($this, LockableCommandInterface::class)) {
                $this->releaseCommand();
            }

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
     * @return bool
     *
     * @throws CommandRuntimeException
     */
    protected function canCommandRun(): bool
    {
        if(is_subclass_of($this, LockableWaitCommandInterface::class)) {
            $this->waitToRunCommand();
            return true;
        } elseif (is_subclass_of($this, LockableCommandInterface::class)) {
            if($this->isCommandRunning()) {
                return false;
            }
        }
        return true;
    }

    /**
     * @return int 0 if everything went fine, or an exit code
     *
     * @throws CommandRuntimeException if an error condition occurs
     */
    protected function preExecuteCommand(): int
    {
        $replacements = $this->handleInputReplacements();
        if ($replacements > 0) {
            $this->io->note(sprintf('Replaced %s %s', number_format($replacements), $replacements === 1 ? 'input' : 'inputs'));
        }
        return static::SUCCESS;
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
        return 0;
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
     * @throws CommandRuntimeException
     */
    abstract protected function executeCommand(): int;

    /**
     * @return int
     *
     * @throws CommandRuntimeException
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