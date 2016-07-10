<?php

namespace Castor;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;

class ProgressIndicator
{
    protected static $instance;

    protected static $output;

    public static function setOutput(OutputInterface $output)
    {
        self::$output = $output;
    }

    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new ProgressBar(self::$output);
            self::$instance->start(100);
        }

        return self::$instance;
    }
}