<?php

namespace Bytes\CommandBundle\Command\Traits;

use Bytes\PluralizeBundle\Pluralize;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
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
     * @param $row
     * @param array $options = ['rowspan' => 1, 'colspan' => 1, 'style' => null]
     * @return Table
     */
    protected function addTableRow($row, array $options = []): Table
    {
        if (empty($this->table)) {
            $this->createTable([]);
        }
        $this->rowCounter++;

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
     * @param array $headers
     * @param string|null $title
     * @param string|null $footer
     * @return Table
     */
    protected function createTable(array $headers, ?string $title = null, ?string $footer = null): Table
    {
        $this->resetTable();
        $table = new Table($this->output);
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
     * @param bool $resetTable
     * @return Table|null
     */
    protected function renderTable(bool $resetTable = true): ?Table
    {
        if (empty($this->table)) {
            $this->createTable([]);
        }
        if ($this->willTableRender()) {
            if (!empty($this->tableFooterText)) {
                $footerText = '';
                if (class_exists(Pluralize::class)) {
                    $footerText = Pluralize::pluralizeFormatted($this->rowCounter, $this->tableFooterText);
                } else {
                    $footerText = $this->rowCounter . ' ' . $this->tableFooterText;
                }
                $this->table->setFooterTitle($footerText);
            }
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
}