<?php

namespace Lookup;

use PDO;
use PDOException;

class Database
{
    public $pdo;
    public static $table;

    public function __construct($options = [])
    {
        $default_options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];
        $options = array_replace($default_options, $options);

        $dbpath = dirname(dirname(__FILE__)) . '/db/lookup.db';

        $dsn = "sqlite:$dbpath";

        try {
            $this->pdo = new PDO($dsn, null, null, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public static function getTables()
    {
        $pdo = new self();
        $sql = "SELECT name FROM sqlite_master WHERE type ='table' AND name NOT LIKE 'sqlite_%'";
        $stmt = $pdo->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function setTable($table) {
        self::$table = $table;
    }

}