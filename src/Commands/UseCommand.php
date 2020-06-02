<?php


namespace Lookup\Commands;


use Lookup\Command;
use Lookup\CommandContext;
use Lookup\Database;

class UseCommand extends Command
{

    public function execute(CommandContext $context)
    {
        $db = new Database();
        if ($context->context['params']) {
            $db->setTable($context->context['params']);
        } else {
            echo $db->getTable();
        }
    }
}