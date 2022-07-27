<?php

namespace Bytes\CommandBundle\Tests\Command;

use Bytes\CommandBundle\Tests\fixtures\Command\SampleLockableSuccessOnlyCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Lock\Store\FlockStore;
use Symfony\Component\Lock\Store\SemaphoreStore;
use function Symfony\Component\String\u;

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
    public function testSampleLockableSuccessOnlyLockedCommandExecute()
    {
        $command = new SampleLockableSuccessOnlyCommand('app:sample');
        $command->setName('app:sample');
        $tester = new CommandTester($command);

        if (!class_exists(SemaphoreStore::class)) {
            throw new LogicException('To enable the locking feature you must install the symfony/lock component.');
        }

        if (SemaphoreStore::isSupported()) {
            $store = new SemaphoreStore();
        } else {
            $store = new FlockStore();
        }

        $lock = (new LockFactory($store))->createLock($command->getName());
        if (!$lock->acquire(false)) {
            $lock = null;
        }

        $tester->execute([]);
        $this->assertEquals(Command::SUCCESS, $tester->getStatusCode());
        $this->assertTrue(u($tester->getDisplay())->trim()->containsAny("[WARNING] The command is already running in another process."));

        $lock->release();
        $lock = null;
    }
}