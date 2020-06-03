<?php


namespace Lookup;

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

    public $context = [];

    public function __construct($input)
    {
        $this->context = $this->parseInput($input);
    }

    public function parseInput($input)
    {
        $context = [];
        if ($firstArg = substr($input, 0, strpos($input, ' '))) {
            if ($expanded = current(self::expandTableShortform($firstArg))) {
                $pattern = '/' . $firstArg . '/';
                $params = preg_replace($pattern, $expanded, $input,1);
                $context['action'] = 'query';
                $context['params'] = $params;
            } else {
                $params = explode(' ', $input);
                $context['action'] = $params[0];
                $context['params'] = $params[1];
            }
        } else {
            $context['action'] = $input;
        }
        return $context;
    }

    /**
     * @param $shortform
     * @return array
     */

    public static function expandTableShortform($shortform) {
        $pattern = '/^' . $shortform . '/';
        if (!$match = preg_grep($pattern, Database::getTables())) {
            throw new TableNotExists('nooo');
        }
        if (count($match) > 1) {
            // TODO: add logic for multiple results with same letter combination. Throw exception?
        }
        return $match;
    }
}