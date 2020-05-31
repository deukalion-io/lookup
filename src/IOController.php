<?php

namespace Lookup;

use LucidFrame\Console\ConsoleTable;

class IOController
{
    public static function processInput($input)
    {
        $parser = ParserFactory::create($input);
        $parsed = $parser->parse();
//        $result = $parser->parseInput();
//        self::processOutput($result);
    }

    public static function processOutput($results)
    {
        $table = new ConsoleTable();
        $headers = array_keys($results[0]);
        $columns = array_values($results[0]);
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