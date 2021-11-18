<?php

namespace Bytes\CommandBundle\Command\Traits;

use Symfony\Component\Console\Helper\ProgressBar;
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
     * @return ProgressBar
     */
    protected function createVeryVerboseProgressBar(): ProgressBar
    {
        $progressBar = new ProgressBar($this->output);
        $progressBar->setFormat('very_verbose');
        return $progressBar;
    }

    /**
     * @param ProgressBar $progressBar
     */
    protected function finishProgressBar(ProgressBar $progressBar) {
        $progressBar->finish();
        $this->io->newLine(2);
    }
}