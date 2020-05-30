<?php

namespace Lookup;

use LucidFrame\Console\ConsoleTable;

class IOController
{

    public function __construct(string $input)
    {
            $parser = new Parser($input);
            $data = $parser->getCombined();
            $query = new Query($data);
            $results = $query->runQuery();
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