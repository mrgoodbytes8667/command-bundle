<?php

namespace Bytes\CommandBundle\Tests\Command;

use Bytes\CommandBundle\Tests\fixtures\Command\SampleCommandRuntimeExceptionMessageCommand;
use Bytes\CommandBundle\Tests\fixtures\Command\SampleCommandRuntimeExceptionMessageReturnSuccessCommand;
use Bytes\CommandBundle\Tests\fixtures\Command\SampleCommandRuntimeExceptionNoArgsCommand;
use Bytes\CommandBundle\Tests\fixtures\Command\SampleFailureInputCommand;
use Bytes\CommandBundle\Tests\fixtures\Command\SampleFailureOnlyCommand;
use Bytes\CommandBundle\Tests\fixtures\Command\SampleInputCommand;
use Bytes\CommandBundle\Tests\fixtures\Command\SampleInteractionCommandRuntimeExceptionMessageCommand;
use Bytes\CommandBundle\Tests\fixtures\Command\SampleNeedsOutputSuccessOnlyCommand;
use Bytes\CommandBundle\Tests\fixtures\Command\SampleSuccessOnlyCommand;
use Bytes\CommandBundle\Tests\fixtures\Command\SampleSuccessOnlyNeedsOutputWithoutVarCommand;
use Bytes\CommandBundle\Tests\fixtures\Command\SampleTimeCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use PHPUnit\Framework\TestCase;
use function Symfony\Component\String\u;

/**
 * Class SampleCommandTest
 * @package Bytes\CommandBundle\Tests\Command
 */
class SampleCommandTest extends TestCase
{
    /**
     *
     */
    public function testSampleSuccessOnlyCommandExecute()
    {
        $command = new SampleSuccessOnlyCommand('app:sample');
        $command->setName('app:sample');
        
        $tester = new CommandTester($command);

        $tester->execute([]);
        $this->assertEquals(Command::SUCCESS, $tester->getStatusCode());
    }

    /**
     *
     */
    public function testSampleFailureOnlyCommandExecute()
    {
        $command = new SampleFailureOnlyCommand('app:sample');
        $command->setName('app:sample');
        
        $tester = new CommandTester($command);

        $tester->execute([]);
        $this->assertEquals(Command::FAILURE, $tester->getStatusCode());

    }

    /**
     *
     */
    public function testSampleInputCommandExecute()
    {
        $command = new SampleInputCommand('app:sample');
        $command->setName('app:sample');
        
        $tester = new CommandTester($command);

        $tester->execute([]);
        $this->assertEquals(Command::FAILURE, $tester->getStatusCode());

        $tester->execute(['--test' => null]);
        $this->assertEquals(Command::SUCCESS, $tester->getStatusCode());

    }

    /**
     *
     */
    public function testSampleFailureInputCommandExecute()
    {
        $command = new SampleFailureInputCommand('app:sample');
        $command->setName('app:sample');
        
        $command->now = new \DateTime();
        $tester = new CommandTester($command);

        $tester->execute([]);
        $this->assertEquals(Command::FAILURE, $tester->getStatusCode());
        $this->assertEquals("[ERROR] Missing option --pre", u($tester->getDisplay())->trim()->toString());

        $tester->execute(['--pre' => null]);
        $this->assertEquals(Command::FAILURE, $tester->getStatusCode());
        $this->assertEquals("[ERROR] Missing option --post", u($tester->getDisplay())->trim()->toString());

        $tester->execute(['--post' => null]);
        $this->assertEquals(Command::FAILURE, $tester->getStatusCode());
        $this->assertEquals("[ERROR] Missing option --pre", u($tester->getDisplay())->trim()->toString());

        $tester->execute(['--pre' => null, '--post' => null]);
        $this->assertEquals(Command::SUCCESS, $tester->getStatusCode());
        $this->assertEquals("! [NOTE] 0d 0h 0m 0s", u($tester->getDisplay())->trim()->toString());

    }

    /**
     *
     */
    public function testSampleCommandRuntimeExceptionNoArgsCommandExecute()
    {
        $command = new SampleCommandRuntimeExceptionNoArgsCommand('app:sample');
        $command->setName('app:sample');
        
        $tester = new CommandTester($command);

        $tester->execute([]);
        $this->assertEquals(Command::FAILURE, $tester->getStatusCode());
    }

    /**
     *
     */
    public function testSampleCommandRuntimeExceptionMessageCommandExecute()
    {
        $command = new SampleCommandRuntimeExceptionMessageCommand('app:sample');
        $command->setName('app:sample');
        
        $tester = new CommandTester($command);

        $tester->execute([]);
        $this->assertEquals(Command::FAILURE, $tester->getStatusCode());
    }

    /**
     *
     */
    public function testSampleInteractionCommandRuntimeExceptionMessageCommandExecute()
    {
        $command = new SampleInteractionCommandRuntimeExceptionMessageCommand('app:sample');
        $command->setName('app:sample');
        
        $tester = new CommandTester($command);

        $tester->execute([]);
        $this->assertEquals(Command::FAILURE, $tester->getStatusCode());
    }

    /**
     *
     */
    public function testSampleCommandRuntimeExceptionMessageReturnSuccessCommandExecute()
    {
        $command = new SampleCommandRuntimeExceptionMessageReturnSuccessCommand('app:sample');
        $command->setName('app:sample');
        
        $tester = new CommandTester($command);

        $tester->execute([]);
        $this->assertEquals(Command::SUCCESS, $tester->getStatusCode());
    }

    /**
     *
     */
    public function testSampleSuccessOnlyNeedsOutputWithoutVarCommand()
    {
        $command = new SampleSuccessOnlyNeedsOutputWithoutVarCommand('app:sample');
        $command->setName('app:sample');
        
        $tester = new CommandTester($command);

        $tester->execute([]);
        $this->assertEquals(Command::SUCCESS, $tester->getStatusCode());
    }
}