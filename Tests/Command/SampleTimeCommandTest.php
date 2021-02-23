<?php

namespace Bytes\CommandBundle\Tests\Command;

use Bytes\CommandBundle\Tests\fixtures\Command\SampleTimeCommand;
use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class SampleTimeCommandTest
 * @package Bytes\CommandBundle\Tests\Command
 */
class SampleTimeCommandTest extends TestCase
{

    /**
     * @var SampleTimeCommand
     */
    private $command;

    /**
     * @var DateTimeImmutable
     */
    private $now;

    /**
     * @var CommandTester
     */
    private $tester;

    public function setUp(): void
    {
        $this->now = new DateTimeImmutable();
        $this->command = new SampleTimeCommand('app:sample');
        $this->command->setName('app:sample');
        $this->tester = new CommandTester($this->command);
    }

    /**
     *
     */
    public function testSampleTimeWithDefaultsCommandExecute()
    {
        $now = $this->timeCommandSetup();
        $this->timeCommandExecute($now);
    }

    /**
     * @param DateTimeZone|string|null $timezone
     * @return DateTime
     */
    protected function timeCommandSetup($timezone = null)
    {
        if (is_null($timezone)) {
            $timezone = $this->command->getOutputTimeZone();
        }
        if (!($timezone instanceof DateTimeZone)) {
            $timezone = new DateTimeZone($timezone);
        }
        $now = DateTime::createFromImmutable($this->now);
        $now->setTimezone($timezone);
        $this->command->now = $now;

        return $now;
    }

    /**
     * @param DateTime $now
     * @param string|null $format
     */
    protected function timeCommandExecute(DateTime $now, string $format = null)
    {
        if (!empty($format)) {
            $this->command->setOutputDateFormat($format);
        }
        $this->tester->execute([]);
        $this->assertEquals(Command::SUCCESS, $this->tester->getStatusCode());
        $this->assertStringContainsString(sprintf("! [NOTE] Command starting at %s", $now->format($format)), $this->tester->getDisplay());
        $this->assertStringContainsString(sprintf("! [NOTE] Command starting at %s", $now->format($this->command->getOutputDateFormat())), $this->tester->getDisplay());
        $this->assertStringContainsString(sprintf("! [NOTE] Command ending at %s", $now->format($format)), $this->tester->getDisplay());
        $this->assertStringContainsString(sprintf("! [NOTE] Command ending at %s", $now->format($this->command->getOutputDateFormat())), $this->tester->getDisplay());
        $this->assertStringContainsString("! [NOTE] 0d 0h 0m 0s", $this->tester->getDisplay());
    }

    /**
     *
     */
    public function testSampleTimeCommandExecute()
    {
        $now = $this->timeCommandSetup('Asia/Beirut');
        $this->timeCommandExecute($now);

        $timezone_identifiers = DateTimeZone::listIdentifiers();
        foreach (array_rand($timezone_identifiers, 3) as $i) {
            $now = $this->timeCommandSetup($timezone_identifiers[$i]);
            $this->timeCommandExecute($now);
        }
    }

    /**
     *
     */
    public function testSampleTimeFormatCommandExecute()
    {
        foreach ([DateTime::ISO8601, DateTime::RFC1123, DateTime::RFC3339] as $format) {
            $now = $this->timeCommandSetup();
            $this->timeCommandExecute($now, $format);
        }
    }
}
