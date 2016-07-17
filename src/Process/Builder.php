<?php

namespace Castor\Process;
use Castor\Contracts\Options\Option;

/**
 * Class Builder.
 */
class Builder
{
    protected $executable;

    protected $options = [];

    public function __construct($executable = 'ffmpeg')
    {
        $this->executable = $executable;
    }

    public function addOption(Option $option = null)
    {
        if ($option) {
            $this->options[] = $option;
        }

        return $this;
    }

    public function build()
    {
        $optionsArray = [];

        foreach($this->options as $option) {
            $optionsArray[] = $option->apply();
        }

        $command = $this->executable;

        foreach($optionsArray as $option) {
            if (!$option) {
                continue;
            }

            if ($option['value']) {
                $command .= " " . $option['option'] . " " . $option['value'];
            } else {
                $command .= " " . $option['option'];
            }
        }

        return $command;
    }
}