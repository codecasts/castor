<?php

namespace Castor\Console\Commands;

use Symfony\Component\Console\Command\Command as ConsoleCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

abstract class Command extends ConsoleCommand
{
    const REQUIRED_ARGUMENT = InputArgument::REQUIRED;

    const OPTIONAL_ARGUMENT = InputArgument::OPTIONAL;

    const ARRAY_ARGUMENT = InputArgument::IS_ARRAY;

    const REQUIRED_VALUE_OPTION = InputOption::VALUE_REQUIRED;

    const OPTIONAL_VALUE_OPTION = InputOption::VALUE_OPTIONAL;

    const ARRAY_VALUE_OPTION = InputOption::VALUE_IS_ARRAY;

    const NO_VALUE_OPTION = InputOption::VALUE_NONE;

    protected $name;

    protected $description;

    protected $arguments = [];

    protected $options = [];

    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var OutputInterface
     */
    protected $output;

    public function configure()
    {
        $this->setName($this->name);
        $this->setDescription($this->description);

        foreach ($this->arguments as $argument) {
            $this->addArgument($argument[0], $argument[1], $argument[2]);
        }

        foreach ($this->options as $option) {
            $this->addOption($option[0], $option[1], $option[2], $option[3], $option[4]);
        }
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $this->fire();
    }

    protected function info($text)
    {
        $this->writeLine($text, 'info');
    }

    protected function comment($text)
    {
        $this->writeLine($text, 'comment');
    }

    protected function question($text)
    {
        $this->writeLine($text, 'question');
    }

    protected function error($text)
    {
        $this->writeLine($text, 'error');
    }

    protected function writeLine($text, $format = null)
    {
        if ($format) {
            $this->output->writeln("<{$format}>{$text}</{$format}>");
        } else {
            $this->output->writeln($text);
        }
    }

    abstract protected function fire();
}
