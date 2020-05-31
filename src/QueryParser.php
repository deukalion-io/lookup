<?php


namespace Lookup;


use stdClass;

class QueryParser
{
    protected $rawInput;
    protected $queryObj;

    public function __construct($input)
    {
        $this->rawInput = $input;
        $this->queryObj = new stdClass();

    }

    public function parse()
    {
        $identifiers = explode(' ', $this->rawInput, 3);
        $this->queryObj->table = $identifiers[0];
        $this->queryObj->name = $identifiers[1];
        if (count($identifiers) == 3) {
            $this->queryObj->fields = $identifiers[2];
        }
        return $this->queryObj;

    }

    public function execute($queryObj) {
        $table = $this->queryObj->table;
        $name = '%' . $this->queryObj->name . '%';
        if ($column = $this->queryObj->column){
            $query = "SELECT {$column} FROM {$table} WHERE name LIKE '{$name}'";
        } else {
            $query = "SELECT * FROM {$table} WHERE name LIKE '{$name}'";
        }
        $pdo = new Database();
        $stmt = $pdo->pdo->query($query);
        return $stmt->fetchAll();
    }
}