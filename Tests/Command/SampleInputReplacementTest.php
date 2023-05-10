<?php

namespace Bytes\CommandBundle\Tests\Command;

use Bytes\CommandBundle\Tests\fixtures\Command\SampleInputReplacementCommand;
use Generator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use function Symfony\Component\String\u;

class SampleInputReplacementTest extends TestCase
{
    /**
     * @return Generator
     */
    public static function provideNoReplacements(): Generator
    {
        yield 'none' => ['input' => []];
        yield 'new true' => ['input' => ['--new' => true]];
        yield 'new false' => ['input' => ['--new' => false]];
        yield 'old false' => ['input' => ['--old' => false]];
    }

    /**
     * @return Generator
     */
    public static function provideReplacements(): Generator
    {
        yield 'old true' => ['input' => ['--old' => true]];
    }

    /**
     * @dataProvider provideNoReplacements
     * @param $input
     * @return void
     */
    public function testNoReplacements($input)
    {
        $command = new SampleInputReplacementCommand('app:sample');
        $command->setName('app:sample');
        
        $tester = new CommandTester($command);

        $tester->execute(input: $input);
        $this->assertEquals(Command::SUCCESS, $tester->getStatusCode());
        self::assertStringNotContainsString("[NOTE] Replaced", u($tester->getDisplay())->trim()->toString());
    }

    /**
     * @dataProvider provideReplacements
     * @param $input
     * @return void
     */
    public function testWithReplacements($input)
    {
        $command = new SampleInputReplacementCommand('app:sample');
        $command->setName('app:sample');
        
        $tester = new CommandTester($command);

        $tester->execute(input: $input);
        $this->assertEquals(Command::SUCCESS, $tester->getStatusCode());
        self::assertStringContainsString("[NOTE] Replaced", u($tester->getDisplay())->trim()->toString());
    }
}
