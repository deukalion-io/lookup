<?php


namespace Lookup;


use Exception;

class CommandNotFound extends Exception
{
    public function __toString()
    {
        return 'No such command or table: "' . $this->getMessage() . '"' . PHP_EOL;
    }
}