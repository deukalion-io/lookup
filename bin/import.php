<?php

use Lookup\Database;

require_once(dirname(__FILE__, 2) . '/vendor/autoload.php');

$fields = ['name', 'level', 'school', 'casting_time', 'range', 'components', 'duration', 'class', 'description'];

$db = new Database();

switch ($argv[1]) {
    case 'spell':
        $f = fopen($argv[2], 'r');
        $arr = [];
        while (!feof($f)) {
            $line = fgets($f);
            if (strpos($line, PHP_EOL) === 0) {
                $columns = implode(',', $fields);
                $sql = "INSERT INTO spell ({$columns}) VALUES (?,?,?,?,?,?,?,?,?)";
                $stmt = $db->pdo->prepare($sql)->execute($arr);
                $arr = [];
            } else {
                // For spell descriptions with more than one paragraph
                $regex = '/^\s\s/';
                if (preg_match($regex, $line)) {
                    $line = array_pop($arr) . "\n" . $line;
                }
                $arr[] = trim($line);
            }
        }
}


