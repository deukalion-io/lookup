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
            if ($expanded = self::expandTableShortform($firstArg)) {
                $params = preg_replace($firstArg, $expanded, $input,1);
                $context['action'] = 'query';
                $context['params'] = $params;
            } else {
                $params = explode(' ', $input, 1);
                $context['action'] = $params[0];
                $context['params'] = $params[1];
            }
        }
        return $context;
    }

    /**
     * @param $shortform
     * @return array
     */

    public static function expandTableShortform($shortform) {
        $shortform = '/^' . $shortform . '/';
        $match = preg_grep($shortform, Database::getTables());
        if (count($match) > 1) {
            // TODO: add logic for multiple results with same letter combination. Throw exception?
        } else {
            return $match;
        }
    }
}