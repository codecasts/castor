<?php

namespace Castor;

use Castor\Contracts\Presets\Preset;
use Castor\Options\General\AutoConfirm;
use Castor\Options\General\Input;
use Castor\Options\General\Output;
use Castor\Options\Thumbnail\Frames;
use Castor\Options\Thumbnail\ThumbnailFilter;
use Castor\Process\Builder;
use Castor\Process\Process;

class Converter
{
    protected $sourceFilePath;

    protected $outputFilePath;

    protected $preset;

    protected $logFile;

    /**
     * @var Process
     */
    protected $process;

    public function __construct(Preset $preset, $sourceFilePath, $outputFilePath)
    {
        $this->sourceFilePath = $sourceFilePath;

        $this->outputFilePath = $outputFilePath;

        $this->preset = $preset;

        $this->logFile = '/tmp/castor_'.date('Y-m-d-H:i:s').'.log';
    }


    /**
     * @return Converter
     */
    public function convert()
    {
        return $this->convertVideo();
    }

    /**
     * @return $this
     */
    protected function convertVideo()
    {
        $processBuilder = new Builder('ffmpeg');

        // Input file
        $processBuilder->addOption(new Input($this->sourceFilePath));

        // Auto Confirm all Dialogs
        $processBuilder->addOption(new AutoConfirm());

        // Preset Options
        $processBuilder
            ->addOption($this->preset->videoCodec())
            ->addOption($this->preset->frameRate())
            ->addOption($this->preset->bitRate())
            ->addOption($this->preset->maxRate())
            ->addOption($this->preset->bufSize())
            ->addOption($this->preset->scale())
            ->addOption($this->preset->audioCodec())
            ->addOption($this->preset->audioBitRate())
            ->addOption($this->preset->fastStart());

        // Output options
        $processBuilder->addOption(new Output($this->outputFilePath));

        $this->process = new Process($processBuilder->build());

        $this->process->run(true, $this->logFile);

        return $this;
    }

    /**
     * @return $this
     */
    public function generateThumbnail()
    {
        $processBuilder = new Builder('ffmpeg');

        // Input file
        $processBuilder->addOption(new Input($this->sourceFilePath));

        // Auto Confirm all Dialogs
        $processBuilder->addOption(new AutoConfirm());

        // Preset Options
        $processBuilder
            ->addOption(new ThumbnailFilter())
            ->addOption(new Frames());

        // Output options
        $processBuilder->addOption(new Output($this->outputFilePath));

        $this->process = new Process($processBuilder->build());

        $this->process->run();

        return $this;
    }

    public function running()
    {
        return $this->process->running();
    }

    public function progress()
    {
        return (new ProgressParser($this->logFile))->getProgress();
    }

}
