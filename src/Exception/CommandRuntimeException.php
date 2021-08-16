<?php

namespace Bytes\CommandBundle\Exception;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Throwable;

/**
 * Can be thrown by child methods outside of executeCommand to return a FAILURE status (overridable via $returnCode)
 * and optionally print to the $io->error() function.
 */
class CommandRuntimeException extends RuntimeException
{
    /**
     * @var bool
     */
    private bool $displayMessage = false;

    /**
     * @var int
     */
    private int $returnCode = Command::FAILURE;

    /**
     * Construct the exception. Note: The message is NOT binary safe.
     * @param string $message [optional] The Exception message to throw.
     * @param bool $displayMessage If true, the contents of message will be printed to $io->error()
     * @param int $returnCode Changes what the return value should be when thrown
     * @param int $code [optional] The Exception code.
     * @param null|Throwable $previous [optional] The previous throwable used for the exception chaining.
     */
    public function __construct($message = "", bool $displayMessage = false, int $returnCode = Command::FAILURE, $code = 0, Throwable $previous = null)
    {
        $this->returnCode = $returnCode;
        $this->displayMessage = $displayMessage;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return bool
     */
    public function shouldDisplayMessage(): bool
    {
        return $this->displayMessage;
    }

    /**
     * @return int
     */
    public function getReturnCode(): int
    {
        return $this->returnCode;
    }
}