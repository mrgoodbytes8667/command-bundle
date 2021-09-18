<?php

namespace Bytes\CommandBundle\Tests\Command;

use Bytes\CommandBundle\Tests\fixtures\Command\SampleNeedsOutputSuccessOnlyCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\PhpUnit\ExpectDeprecationTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

/**
 *
 */
class LegacySampleCommandTest extends TestCase
{
    use ExpectDeprecationTrait;

    /**
     *
     */
    public function testSampleNeedsOutputSuccessOnlyCommandExecute()
    {
        $this->expectDeprecation('Since mrgoodbytes8667/command-bundle 1.2.1: The "$needsOutput" variable is deprecated. Output will always be set regardless of value and the variable declaration should be removed.');

        $command = new SampleNeedsOutputSuccessOnlyCommand('app:sample');
        $command->setName('app:sample');
        $tester = new CommandTester($command);

        $tester->execute([]);
        $this->assertEquals(Command::SUCCESS, $tester->getStatusCode());
    }
}