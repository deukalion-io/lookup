<?php

namespace Lookup;

use Lookup\Exceptions\CommandNotFound;

class CommandFactory
{
    public static function getCommand($action): Command
    {
        $command = null;
        try {
            $class = self::getCommandClass($action);
            $command = new $class;
        }
        catch (CommandNotFound $e) {
            echo $e;
        }
        return $command;
    }

    public static function getCommandClass($action): string
    {
        $class = __NAMESPACE__ . "\\Commands\\" . UCFirst(strtolower($action));
        if (! class_exists($class)) {
            throw new CommandNotFound($action);
        }
        return $class;
    }


}