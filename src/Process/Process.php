<?php

namespace Castor\Process;

/**
 * Class Process.
 */
class Process
{
    /**
     * @var string
     */
    protected $command;

    /**
     * @var array
     */
    protected $descriptorSpec = [
        0 => ['pipe', 'r'],
        1 => ['pipe', 'w'],
        2 => ['pipe', 'w']
    ];

    protected $process;

    public function __construct($command)
    {

        $this->command = $command;
    }

    public function run($background = false, $logTo = false)
    {
        $command = $this->command;

        if ($background) {
            $logToPath = $logTo ? $logTo : '/dev/null';
            $command .= " 1> {$logToPath} 2>&1";
        }

        $this->process = proc_open($command, $this->descriptorSpec, $pipes);
    }

    protected function getStatus()
    {
        $status = proc_get_status($this->process);

        return $status;
    }

    public function running()
    {
        $status = $this->getStatus();

        return (bool) $status['running'];
    }

    public function pid()
    {
        $status = $this->getStatus();

        return (bool) $status['pid'];
    }
}