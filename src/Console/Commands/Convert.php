<?php

namespace Castor\Console\Commands;

use Castor\Console\FileNotFound;
use Castor\Contracts\Presets\Preset;
use Castor\Converter;
use Castor\Exceptions\PresetNotFound;
use Castor\Presets\Screencast;
use Symfony\Component\Console\Helper\ProgressBar;

class Convert extends Command
{
    protected $name = 'convert';

    protected $description = 'Convert a H264 applying a predefined preset';

    protected $arguments = [
        ['source', self::REQUIRED_ARGUMENT, 'H264 File to process'],
        ['output', self::OPTIONAL_ARGUMENT, 'H264 Output file, defaults to out_{original_name}'],
    ];

    protected $options = [
        ['preset', 's', self::OPTIONAL_VALUE_OPTION, 'Preset to use', 'screencast'],
        ['thumbnail', 't', self::OPTIONAL_VALUE_OPTION, 'Generates a Thumbnail of the Resulting Video', false],
    ];

    protected $presets = [
        'screencast' => Screencast::class,
    ];

    /**
     * @var string
     */
    protected $sourceFilePath;

    /**
     * @var string
     */
    protected $outputFilePath;

    /**
     * @var Preset
     */
    protected $outputPreset;

    /**
     * @var bool
     */
    protected $thumbnailEnabled;

    /**
     * @var string
     */
    protected $thumbnailPath;

    /**
     * @var ProgressBar
     */
    protected $progressBar;

    /**
     * @return string
     */
    protected function getSourceFilePath()
    {
        // Detect Real file name
        $sourceFileName = realpath($this->input->getArgument('source'));

        // Check for file existence
        if (!file_exists($sourceFileName)) {
            throw new FileNotFound('Source file not found.');
        }

        return $sourceFileName;
    }

    /**
     * @return mixed
     */
    protected function getOutputFilePath()
    {
        $outputFilePath = $this->input->getArgument('output');
        if (!$outputFilePath) {
            $outputFilePath = str_replace('.mp4', '_out.mp4', $this->sourceFilePath);
        }

        return $outputFilePath;
    }

    protected function getOutputPreset()
    {
        $preset = $this->input->getOption('preset');
        
        if (!array_key_exists($preset, $this->presets)) {
            throw new PresetNotFound();
        }

        return new $this->presets[$preset]();
    }

    protected function shouldGenerateThumbnail()
    {
        return (bool) $this->input->getOption('thumbnail');
    }

    protected function detectOptions()
    {
        // Source file path
        $this->sourceFilePath = $this->getSourceFilePath();

        // Output file name
        $this->outputFilePath = $this->getOutputFilePath();

        // Using the preset
        $this->outputPreset = $this->getOutputPreset();

        // Generate Thumbnail?
        $this->thumbnailEnabled = $this->shouldGenerateThumbnail();

        if ($this->thumbnailEnabled) {
            $this->thumbnailPath = str_replace('.mp4', '.jpg', $this->outputFilePath);
        }

    }

    protected function fire()
    {
        $this->detectOptions();

        $this->comment("Converting: {$this->sourceFilePath}\n");
        $this->comment("Output Video: {$this->outputFilePath}\n");

        if ($this->thumbnailEnabled) {
            $this->comment("Output Thumbnail: {$this->thumbnailPath}");
        }

        $this->info("\n\nHold on...\n\n");

        $converter = new Converter(
            $this->outputPreset,
            $this->sourceFilePath,
            $this->outputFilePath);

        $converter = $converter->convert(false);

        $this->startProgressBar();

        while($converter->running()) {
            $this->setProgress($converter->progress());
            sleep(3);
        }

        $this->info("\n\nVideo Converted!");

        if ($this->thumbnailEnabled) {
            $this->comment("\n\nGenerating Thumbnail...");

            $converter = new Converter(
                $this->outputPreset,
                $this->outputFilePath,
                $this->thumbnailPath
            );

            $converter->generateThumbnail();
        }


        $this->info("\n\nAll Done, That's all folks :)\n\n");
    }

    protected function startProgressBar()
    {
        $this->progressBar = new ProgressBar($this->output, 100);
    }

    protected function setProgress($percentage)
    {
        $this->progressBar->setProgress($percentage);
    }

    protected function finishProgressBar()
    {
        $this->progressBar->setProgress(100);
        $this->progressBar->finish();
    }
}
