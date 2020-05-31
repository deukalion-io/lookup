<?php


namespace Lookup;

class ParserFactory
{
    /**
     * ParserFactory constructor.
     * @param $input
     */

    public static function create($input)
    {
        $firstArg = substr($input, 0, strpos($input, ' '));
        if ($expanded = self::expandTableShortform($firstArg)) {
            $input = preg_replace($firstArg, $expanded, $input,1);
            return new QueryParser($input);
        } else {
            return new CommandParser($input);
        }
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