<?php

namespace Bytes\CommandBundle\Command\Traits;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @property OutputInterface $output
 * @property SymfonyStyle $io
 * @experimental
 */
trait ProgressBarHelperTrait
{
    /**
     * @param OutputInterface|null $output
     * @return ProgressBar
     */
    protected function createVeryVerboseProgressBar(?OutputInterface $output = null): ProgressBar
    {
        $progressBar = new ProgressBar($output instanceof ConsoleOutputInterface ? $output : $this->output);
        $progressBar->setFormat('very_verbose');
        return $progressBar;
    }

    /**
     * @param ProgressBar $progressBar
     */
    protected function finishProgressBar(ProgressBar $progressBar)
    {
        $progressBar->finish();
        $this->io->newLine(2);
    }
}