<?php

namespace Bytes\CommandBundle\Tests\Command;

use Bytes\CommandBundle\Tests\fixtures\Command\SampleLockableSuccessOnlyCommand;
use Bytes\CommandBundle\Tests\fixtures\Command\SampleLockableWaitSuccessOnlyCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class SampleLockableCommandTest extends TestCase
{
    /**
     *
     */
    public function testSampleLockableSuccessOnlyCommandExecute()
    {
        $command = new SampleLockableSuccessOnlyCommand('app:sample');
        $command->setName('app:sample');
        
        $tester = new CommandTester($command);

        $tester->execute([]);
        $this->assertEquals(Command::SUCCESS, $tester->getStatusCode());
    }

    /**
     *
     */
    public function testSampleLockableWaitSuccessOnlyCommandExecute()
    {
        $command = new SampleLockableWaitSuccessOnlyCommand('app:sample');
        $command->setName('app:sample');
        
        $tester = new CommandTester($command);

        $tester->execute([]);
        $this->assertEquals(Command::SUCCESS, $tester->getStatusCode());
    }
}
