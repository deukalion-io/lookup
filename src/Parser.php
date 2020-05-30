<?php

namespace Lookup;

use Lookup\Database;


/**
 * Class Parser.
 * @package Lookup
 */

class Parser
{
    const TABLE_WHITELIST = [
        'mon' => 'monster',
        'spe' => 'spell'
    ];

    protected $combined = ['table', 'name', 'column'];
    protected $values;

    public function __construct($line)
    {
        $this->values = $this->expand_shorthand(explode(' ', $line));
    }

    protected function array_combine_unequal($arr1, $arr2) {
        $count = min(count($arr1), count($arr2));
        return array_combine(array_slice($arr1, 0, $count), array_slice($arr2, 0, $count));
    }

    public function getCombined() {
        return $this->array_combine_unequal($this->combined, $this->values);
    }

    protected function expand_shorthand($values) {
        foreach ($values as $index => $val) {
            if (in_array(substr($val, 0, 3), array_keys(self::TABLE_WHITELIST))) {
                $values[$index] = self::TABLE_WHITELIST[$val];
            }
        }
        return $values;
    }

}