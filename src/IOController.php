<?php

namespace Lookup;

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

    public function process()
    {
        $action = $this->context['action'];
        $action = ( is_null($action) ) ? "default" : $action;
        $cmd = CommandFactory::getCommand($action);
        if (! $cmd->execute($this->context)) {
            // handle failure
                    } else {
            // success
            // dispatch view
        }
    }

//    public static function processOutput($results)
//    {
//        $table = new ConsoleTable();
//        $headers = array_keys($results[0]);
//        $columns = array_values($results[0]);
//        foreach ($headers as $header) {
//            $table->addRow()
//                ->addHeader($header);
//        }
//        foreach ($columns as $column) {
//            $table->addColumn($column);
//        }
//        $table->display();
//    }
}