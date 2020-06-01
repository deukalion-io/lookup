<?php


namespace Lookup;


use Exception;

class CommandFactory
{
    private static $dir = 'commands';

    public static function getCommand(string $action = 'Default'): Command
    {
        if (preg_match('/\W/', $action)) {
            throw new Exception("illegal characters in action");
        }

        $class = __NAMESPACE__ . "\\commands\\" . UCFirst(strtolower($action)) . "Command";

        if (! class_exists($class)) {
            throw new CommandNotFoundException("no '$class' class located");
        }

        return new $class();
    }
}