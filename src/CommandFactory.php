<?php

namespace Lookup;

use Exception;

class CommandFactory
{

    public static function getCommand(string $action = 'Default'): Command
    {
        if (preg_match('/\W/', $action)) {
            throw new Exception("illegal characters in action");
        }
        $class = __NAMESPACE__ . "\\Commands\\" . UCFirst(strtolower($action)) . "Command";
        if (! class_exists($class)) {
            throw new CommandNotFound($action);
        }
        return new $class();
    }
}