<?php

namespace Bytes\CommandBundle\Tests\Command;

use Bytes\CommandBundle\Tests\fixtures\Command\SampleSuccessOnlyEntityCommand;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class SampleEntityCommandTest
 * @package Bytes\CommandBundle\Tests\Command
 */
class SampleEntityCommandTest extends TestCase
{
    /**
     *
     */
    public function testSampleSuccessOnlyCommandExecute()
    {
        $manager = $this->getMockBuilder(EntityManagerInterface::class)->getMock();

        $command = new SampleSuccessOnlyEntityCommand($manager, 'app:sample');
        $command->setName('app:sample');
        
        $tester = new CommandTester($command);

        $tester->execute([]);
        $this->assertEquals(Command::SUCCESS, $tester->getStatusCode());

    }
}
