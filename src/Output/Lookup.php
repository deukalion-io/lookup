<?php


namespace Lookup\Output;


use LucidFrame\Console\ConsoleTable;

class Lookup
{
    public $output;

    public function __construct($output)
    {
        $this->output = $this->formatOutput($output);
    }

    public function formatOutput($output)
    {
        $table = new ConsoleTable();
        foreach ($output as $row) {
            $table->addRow();
            $columns = array_values($row);
            foreach ($columns as $column) {
                $table->addColumn($column);
            }
        }
        $this->output = $table->getTable();
    }

    public function printOutput()
    {
        echo $this->output;
    }

}