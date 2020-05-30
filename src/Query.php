<?php


namespace Lookup;


class Query
{

    protected $data;
    protected $query;
    public $pdo;

    public function __construct($data)
    {
        $this->data = $data;
        $table = $data['table'];
        $name = '%' . $data['name'] . '%';
        $column = $data['column'] ?? null;
        if ($column){
            $query = "SELECT {$column} FROM {$table} WHERE name LIKE '{$name}'";
        } else {
            $query = "SELECT * FROM {$table} WHERE name LIKE '{$name}'";
        }
        $this->query = $query;
        $this->pdo = new Database();
    }

    public function runQuery() {
        $stmt = $this->pdo->pdo->query($this->query);
        return $stmt->fetchAll();
    }
}