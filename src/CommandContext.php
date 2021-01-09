<?php


namespace Lookup;

use Lookup\Exceptions\CommandOrTableNotFound;

/**
 * Class CommandContext
 * Parses and prepares input.
 *
 * "This is a mechanism by which request data can be passed to Command objects, and by which responses can be
 * channeled back to the view layer. Using an object in this way is useful because I can pass different
 * parameters to commands without breaking the interface." — Matt Zendstra in PHP Objects, Patterns & Practice
 *
 * @package Lookup
 */

class CommandContext
{
    /**
     * @var $input string string from user
     */
    public $input;

    /**
     * @var $context array parameters for execute method
     */
    public $context = [];

    /**
     * CommandContext constructor.
     * @param $input
     */
    public function __construct($input)
    {
        $this->input = $input;
        try {
            $this->context = $this->parseInput($input);
        } catch (CommandOrTableNotFound $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Determine if user requested a specific command or the default table lookup.
     *
     * @param $input
     * @return array
     * @throws CommandOrTableNotFound
     */
    public function parseInput($input): array
    {
        $context = [];
        [$first, $rest] = explode(' ', $input, 2);
            if ($expanded = self::getFullTableName($first)) {
            $context['action'] = 'lookup';
            $context['params'] = $expanded . ' ' . $rest;
        } elseif (CommandFactory::getCommandClass($first)) {
            $context['action'] = $first;
            $context['params'] = $rest;
        } else {
            throw new CommandOrTableNotFound($first);
        }
        return $context;
    }

    /**
     * Expand table name if short form is provided.
     *
     * @param $shortform
     * @return string
     */

    public static function getFullTableName($shortform): string
    {
        $pattern = '/^' . $shortform . '/';
        if ($match = preg_grep($pattern, Database::getTables())) {
            return $match[0];
        }
        return '';
    }
}