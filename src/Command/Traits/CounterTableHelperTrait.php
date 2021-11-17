<?php

namespace Bytes\CommandBundle\Command\Traits;

use Bytes\PluralizeBundle\Pluralize;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @property OutputInterface $output
 * @property SymfonyStyle $io
 */
trait CounterTableHelperTrait
{
    /**
     * @var int
     */
    protected $rowCounter = 0;

    /**
     * @var Table
     */
    protected $table;

    /**
     * @var string|null
     */
    protected $tableFooterText;

    /**
     * @param array $headers
     * @param string|null $title
     * @param string|null $footer
     * @return Table
     */
    protected function createTable(array $headers, ?string $title = null, ?string $footer = null): Table
    {
        $this->rowCounter = 0;
        $table = new Table($this->output);
        $table->setHeaders($headers);
        if(!empty($title)) {
            $table->setHeaderTitle($title);
        }
        $this->tableFooterText = $footer;

        return $this->table = $table;
    }

    /**
     * @param $row
     * @return Table
     */
    protected function addTableRow($row)
    {
        if(empty($this->table)) {
            $this->createTable([]);
        }
        $this->rowCounter++;
        return $this->table->addRow($row);
    }

    /**
     * @param bool $hasProgressBar
     * @return Table
     */
    protected function renderTable(bool $hasProgressBar = false): Table
    {
        if(empty($this->table)) {
            $this->createTable([]);
        }
        if($this->rowCounter > 0) {
            if($hasProgressBar) {
                $this->io->newLine(2);
            }
            if(!empty($this->tableFooterText)) {
                $footerText = '';
                if(class_exists(Pluralize::class)) {
                    $footerText = Pluralize::pluralize($this->rowCounter, $this->tableFooterText);
                } else {
                    $footerText = $this->rowCounter . ' ' . $this->tableFooterText;
                }
                $this->table->setFooterTitle($footerText);
            }
            $this->table->render();
        }

        return $this->table;
    }
}