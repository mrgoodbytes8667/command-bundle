<?php


namespace Bytes\CommandBundle\Command;


use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class CommandStyle
 * Main intention is to allow for the commands to be able to easily show error() calls when in --quiet
 *
 * @package Bytes\CommandBundle\Command
 */
class CommandStyle extends SymfonyStyle
{
    /**
     * @var int = [self::VERBOSITY_QUIET, self::VERBOSITY_NORMAL, self::VERBOSITY_VERBOSE, self::VERBOSITY_VERY_VERBOSE, self::VERBOSITY_DEBUG, self::OUTPUT_NORMAL, self::OUTPUT_RAW, self::OUTPUT_PLAIN][$any]
     */
    private $forceType = self::OUTPUT_NORMAL;

    /**
     * Formats an error result bar.
     *
     * @param string|array $message
     */
    public function error($message)
    {
        $this->forceType = self::VERBOSITY_QUIET;
        parent::error($message);
        $this->forceType = self::OUTPUT_NORMAL;
    }

    /**
     * Writes a message to the output.
     *
     * @param string|iterable $messages The message as an iterable of strings or a single string
     * @param bool $newline Whether to add a newline
     * @param int $type A bitmask of options (one of the OUTPUT or VERBOSITY constants), 0 is considered the same as self::OUTPUT_NORMAL | self::VERBOSITY_NORMAL
     */
    public function write($messages, bool $newline = false, int $type = self::OUTPUT_NORMAL)
    {
        parent::write($messages, $newline, $type != self::OUTPUT_NORMAL ? $type : $this->forceType);
    }

    /**
     * Writes a message to the output and adds a newline at the end.
     *
     * @param string|iterable $messages The message as an iterable of strings or a single string
     * @param int $type A bitmask of options (one of the OUTPUT or VERBOSITY constants), 0 is considered the same as self::OUTPUT_NORMAL | self::VERBOSITY_NORMAL
     */
    public function writeln($messages, int $type = self::OUTPUT_NORMAL)
    {
        parent::writeln($messages, $type != self::OUTPUT_NORMAL ? $type : $this->forceType);
    }
}