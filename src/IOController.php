<?php

namespace Lookup;

use Exception;
use LucidFrame\Console\ConsoleTable;

/**
 * Class IOController
 *
 * Represents "invoker" role in Command Pattern.
 *
 * @package Lookup
 */
class IOController
{
    private $context;

    public function __construct($input)
    {
        $this->context = new CommandContext($input);
    }

    public function processInput()
    {
        $action = $this->context->context['action'];
        $action = ( is_null($action) ) ? "default" : $action;
        try {
            $cmd = CommandFactory::getCommand($action);
            if (! $output = $cmd->execute($this->context)) {
                // handle failure
            } else {
                $this->processOutput($output);
            }
        }
        catch (Exception $e) {
            echo $e;
        }
    }

    public function processOutput($output)
    {
        $table = new ConsoleTable();
        $headers = array_keys($output[0]);
        $columns = array_values($output[0]);
        foreach ($headers as $header) {
            $table->addRow()
                ->addHeader($header);
        }
        foreach ($columns as $column) {
            $table->addColumn($column);
        }
        $table->display();
    }
}