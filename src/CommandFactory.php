<?php

namespace Lookup;

use Exception;
use Lookup\Exceptions\CommandNotFound;

class CommandFactory
{
    public static function getCommand(string $action = 'Default'): Command
    {
        $command = null;
        try {
            $class = self::getCommandClass($action);
            $command = new $class;
        }
        catch (Exception $e) {
            echo $e;
        }
        return $command;
    }

    public static function getCommandClass($action)
    {
        $class = __NAMESPACE__ . "\\Commands\\" . UCFirst(strtolower($action)) . "Command";
        if (! class_exists($class)) {
            throw new CommandNotFound($action);
        }
        return $class;
    }


}