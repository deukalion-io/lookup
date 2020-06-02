<?php

namespace Lookup\Commands;

use Lookup\Command;
use Lookup\CommandContext;
use Lookup\Database;
use Lookup\Util;
use stdClass;

class QueryCommand extends Command
{
    public function parse($context)
    {
        $queryObj = new stdClass();
        $identifiers = explode(' ', $context['params'], 3);
        $queryObj->table = $identifiers[0];
        $queryObj->name = $identifiers[1];
        if (count($identifiers) == 3) {
            $queryObj->fields = $identifiers[2];
        }
        return $queryObj;
    }

    public function execute(CommandContext $context)
    {
        $queryObj = $this->parse($context->context);
        $table = $queryObj->table;
        $name = Util::wrap_in_char($queryObj->name, '%');
        if ($column = $queryObj->fields){
            $query = "SELECT {$column} FROM {$table} WHERE name LIKE '{$name}'";
        } else {
            $query = "SELECT * FROM {$table} WHERE name LIKE '{$name}'";
        }
        $pdo = new Database();
        $stmt = $pdo->pdo->query($query);
        return $stmt->fetchAll();
    }
}