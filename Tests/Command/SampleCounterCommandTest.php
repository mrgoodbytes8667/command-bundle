<?php

namespace Bytes\CommandBundle\Tests\Command;

use Bytes\CommandBundle\Command\Traits\CounterTableHelperTrait;
use Bytes\CommandBundle\Tests\fixtures\Command\SampleCounterCommand;
use Bytes\CommandBundle\Tests\fixtures\Command\SampleCounterCommandNoSeparator;
use Bytes\CommandBundle\Tests\fixtures\Command\SampleCounterCommandNoTableRenders;
use Bytes\CommandBundle\Tests\fixtures\Command\SampleCounterCommandNumerousRows;
use Bytes\CommandBundle\Tests\fixtures\Command\SampleCounterCommandTableRenders;
use Bytes\CommandBundle\Tests\fixtures\Command\SampleCounterCommandWithSeparator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use function Symfony\Component\String\u;

/**
 *
 */
class SampleCounterCommandTest extends TestCase
{
    use CounterTableHelperTrait;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    /**
     *
     */
    public function testSampleSuccessOnlyCommandExecute()
    {
        $command = new SampleCounterCommand('app:sample');
        $command->setName('app:sample');
        
        $tester = new CommandTester($command);

        $tester->execute([]);
        $this->assertEquals(Command::SUCCESS, $tester->getStatusCode());
    }

    /**
     *
     */
    public function testSampleTableRendersCommandExecute()
    {
        $command = new SampleCounterCommandTableRenders('app:sample');
        $command->setName('app:sample');
        
        $tester = new CommandTester($command);

        $tester->execute([]);
        $this->assertEquals(Command::SUCCESS, $tester->getStatusCode());
        $this->assertStringContainsString('Header', $tester->getDisplay());
        $this->assertStringContainsString('Column A', $tester->getDisplay());
        $this->assertStringContainsString('Column B', $tester->getDisplay());
    }

    /**
     *
     */
    public function testSampleNoTableRendersCommandExecute()
    {
        $command = new SampleCounterCommandNoTableRenders('app:sample');
        $command->setName('app:sample');
        
        $tester = new CommandTester($command);

        $tester->execute([]);
        $this->assertEquals(Command::SUCCESS, $tester->getStatusCode());
        $this->assertStringNotContainsString('Header', $tester->getDisplay());
        $this->assertStringNotContainsString('Column A', $tester->getDisplay());
        $this->assertStringNotContainsString('Column B', $tester->getDisplay());
    }

    /**
     *
     */
    public function testSampleTableWithSeparatorCommandExecute()
    {
        $command = new SampleCounterCommandWithSeparator('app:sample');
        $command->setName('app:sample');
        
        $tester = new CommandTester($command);

        $tester->execute([]);
        $this->assertEquals(Command::SUCCESS, $tester->getStatusCode());
        $this->assertStringContainsString('Column A', $tester->getDisplay());
        $this->assertStringContainsString('Column B', $tester->getDisplay());
        $output = u($tester->getDisplay())->afterLast('Column B |')->before(' // Done')->trim()->toString();
        $this->assertEquals(6, substr_count($output, '+'));
    }

    /**
     *
     */
    public function testSampleTableNoSeparatorCommandExecute()
    {
        $command = new SampleCounterCommandNoSeparator('app:sample');
        $command->setName('app:sample');
        
        $tester = new CommandTester($command);

        $tester->execute([]);
        $this->assertEquals(Command::SUCCESS, $tester->getStatusCode());
        $this->assertStringContainsString('Column A', $tester->getDisplay());
        $this->assertStringContainsString('Column B', $tester->getDisplay());
        $output = u($tester->getDisplay())->afterLast('Column B |')->before(' // Done')->trim()->toString();
        $this->assertEquals(3, substr_count($output, '+'));
    }

    /**
     *
     */
    public function testSampleNumerousRowsCommandExecute()
    {
        $command = new SampleCounterCommandNumerousRows('app:sample');
        $command->setName('app:sample');
        
        $tester = new CommandTester($command);

        $tester->execute([]);
        $this->assertEquals(Command::SUCCESS, $tester->getStatusCode());
        $this->assertStringContainsString('Header', $tester->getDisplay());
        $this->assertStringContainsString('Column A', $tester->getDisplay());
        $this->assertStringContainsString('Column B', $tester->getDisplay());
        $this->assertStringContainsString('1,234 rows', $tester->getDisplay());
    }
}
