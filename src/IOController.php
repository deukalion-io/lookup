<?php

namespace Lookup;

use Exception;
use LucidFrame\Console\ConsoleTable;

/**
 * Class IOController
 *
 * Represents "invoker" role in Command Pattern.
 *
 * @package Lookup
 */
class IOController
{
    private $context;

    public $output;

    public function __construct($input)
    {
        $this->context = new CommandContext($input);
    }

    public function processInput()
    {
        $cmd = CommandFactory::getCommand($this->context->context['action']);
        if (! $output = $cmd->execute($this->context)) {
            // handle failure
        } else {
            $this->output = $output;
        }
    }

    public function processOutput()
    {

//        $fields = ['Name', 'Level', 'School', 'Casting time', 'Range', 'Components', 'Duration', 'Classes', 'Description'];
//        $longest = 0;
//        foreach ($fields as $field) {
//            $length = strlen($field);
//            if ($length > $longest) {
//                $longest = $length;
//            }
//        }
//        foreach ($output as $result) {
//            // Remove ID field
//            array_shift($result);
//            $arr = array_combine($fields, $result);
//            foreach ($arr as $header => $value) {
//                $header = str_pad($header, $longest, ' ', STR_PAD_LEFT );
//                echo $header. ': ' . $value . "\n";
//            }
//        }
        //if ($this->context->context[''])


    }
}