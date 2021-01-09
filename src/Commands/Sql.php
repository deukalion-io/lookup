<?php


namespace Lookup\Commands;


use Lookup\CommandContext;
use Lookup\Database;
use Lookup\Util;

class Sql extends \Lookup\Command
{
    /**
     * Execute input as SQL statement. LIKE values are properly wrapped in wildcard characters.
     *
     * @param CommandContext $context
     * @return array
     */
    public function execute(CommandContext $context): array
    {
        $sql = $context->context['params'];
        preg_match_all('/(?<=like\s)\w+/', $sql , $matches);
        foreach ($matches[0] as $match) {
            $escaped = Util::wrap_in_char($match, "'%");
            $sql = substr_replace($sql, $escaped, strpos($sql, $match));
        }
        $pdo = new Database();
        $stmt = $pdo->pdo->query($sql);
        return $stmt->fetchAll();
    }
}