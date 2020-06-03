<?php


namespace Lookup;


class TableNotExists extends \Exception
{
    public function __toString()
    {
        echo "No such table.";
    }
}