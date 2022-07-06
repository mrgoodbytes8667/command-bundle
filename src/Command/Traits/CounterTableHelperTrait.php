<?php

namespace Bytes\CommandBundle\Command\Traits;

use Bytes\PluralizeBundle\Pluralize;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\ConsoleSectionOutput;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @property OutputInterface $output
 * @experimental
 */
trait CounterTableHelperTrait
{
    /**
     * @var int
     */
    protected $rowCounter = 0;

    /**
     * @var Table|null
     */
    protected $table;

    /**
     * @var string|null
     */
    protected $tableFooterText;

    /**
     * @var ConsoleSectionOutput|null
     */
    protected $section;

    /**
     * @param $row
     * @param array $options = ['rowspan' => 1, 'colspan' => 1, 'style' => null]
     * @param bool $doIncrementRowCount
     * @return Table
     */
    protected function addTableRow($row, array $options = [], bool $doIncrementRowCount = true): Table
    {
        if (empty($this->table)) {
            $this->createTable([]);
        }
        if ($doIncrementRowCount) {
            $this->rowCounter++;
        }

        if (!empty($options)) {
            foreach ($row as $index => $text) {

                $row[$index] = new TableCell(
                    $text,
                    $options,
                );
            }
        }

        return $this->table->addRow($row);
    }

    /**
     * @param array $options
     * @param bool $doIncrementRowCount
     * @return Table
     */
    protected function addTableSeparator(array $options = [], bool $doIncrementRowCount = false): Table
    {
        return $this->addTableRow(new TableSeparator($options), doIncrementRowCount: $doIncrementRowCount);
    }

    /**
     * @param array $headers
     * @param string|null $title
     * @param string|null $footer
     * @return Table
     */
    protected function createTable(array $headers, ?string $title = null, ?string $footer = null): Table
    {
        $this->resetTable();
        $output = $this->output;
        if ($this->output instanceof ConsoleOutputInterface) {
            $this->section = $this->output->section();
            $output = $this->section;
        }
        $table = new Table($output);
        $table->setHeaders($headers);
        if (!empty($title)) {
            $table->setHeaderTitle($title);
        }
        $this->tableFooterText = $footer;

        return $this->table = $table;
    }

    /**
     *
     */
    protected function resetTable()
    {
        $this->table = null;
        $this->rowCounter = 0;
        $this->tableFooterText = null;
    }

    /**
     * @param $row
     * @param array $options = ['rowspan' => 1, 'colspan' => 1, 'style' => null]
     * @param bool $doIncrementRowCount
     * @return Table
     */
    protected function appendTableRow($row, array $options = [], bool $doIncrementRowCount = true): Table
    {
        if (empty($this->table)) {
            $this->createTable([]);
        }
        if ($doIncrementRowCount) {
            $this->rowCounter++;
        }

        if (!empty($options)) {
            foreach ($row as $index => $text) {
                $row[$index] = new TableCell(
                    $text,
                    $options,
                );
            }
        }

        return $this->table->appendRow($row);
    }

    /**
     * @param bool $resetTable
     * @param bool $forceRender
     * @return Table|null
     */
    protected function renderTable(bool $resetTable = true, bool $forceRender = false): ?Table
    {
        if (empty($this->table)) {
            $this->createTable([]);
        }
        if ($this->willTableRender() || $forceRender) {
            $this->renderTableFooter();
            $this->table->render();
        }

        if ($resetTable) {
            $this->resetTable();
        }

        return $this->table;
    }

    /**
     * @return bool
     */
    protected function willTableRender(): bool
    {
        return $this->rowCounter > 0;
    }

    /**
     * @return Table|null
     */
    public function renderTableFooter(): ?Table
    {
        if (!empty($this->tableFooterText)) {
            $footerText = '';
            if (class_exists(Pluralize::class)) {
                $footerText = Pluralize::pluralizeFormatted($this->rowCounter, $this->tableFooterText);
            } else {
                $footerText = number_format($this->rowCounter) . ' ' . $this->tableFooterText;
            }
            $this->table->setFooterTitle($footerText);
        }

        return $this->table;
    }
}