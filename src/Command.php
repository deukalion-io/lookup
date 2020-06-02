<?php


namespace Lookup;


abstract class Command
{
    abstract public function execute(CommandContext $context);
}