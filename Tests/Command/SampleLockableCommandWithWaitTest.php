<?php

namespace Bytes\CommandBundle\Tests\Command;

use Bytes\CommandBundle\Tests\fixtures\Command\SampleLockableSuccessOnlyCommand;
use Bytes\CommandBundle\Tests\fixtures\Command\SampleLockableWaitSuccessOnlyCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Lock\BlockingStoreInterface;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Lock\LockInterface;
use Symfony\Component\Lock\Store\FlockStore;
use Symfony\Component\Lock\Store\SemaphoreStore;
use function Symfony\Component\String\u;

class SampleLockableCommandWithWaitTest extends TestCase
{
    /**
     * @var LockInterface|null 
     */
    private $lock;

    /**
     * @var BlockingStoreInterface|null
     */
    private $store;

    public function setUp(): void
    {
        if (!class_exists(SemaphoreStore::class)) {
            throw new LogicException('To enable the locking feature you must install the symfony/lock component.');
        }
        $this->lock = null;

        if (SemaphoreStore::isSupported()) {
            $this->store = new SemaphoreStore();
        } else {
            $this->store = new FlockStore();
        }
    }

    /**
     *
     */
    public function testSampleLockableSuccessOnlyLockedCommandExecute()
    {
        $command = new SampleLockableSuccessOnlyCommand('app:sample');
        $command->setName('app:sample');
        $tester = new CommandTester($command);

        $this->lock = (new LockFactory($this->store))->createLock($command->getName());
        if (!$this->lock->acquire(false)) {
            $this->lock = null;
        }

        $tester->execute([]);
        $this->assertEquals(Command::SUCCESS, $tester->getStatusCode());
        $this->assertTrue(u($tester->getDisplay())->trim()->containsAny("[WARNING] The command is already running in another process."));
    }

    /**
     * This method is called after each test.
     */
    protected function tearDown(): void
    {
        $this->lock->release();
        $this->lock = null;
        $this->store = null;
    }
}