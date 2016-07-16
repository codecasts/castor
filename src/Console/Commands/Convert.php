<?php

namespace Castor\Console\Commands;

use Castor\Console\FileNotFound;
use Castor\Converter;
use Castor\Exceptions\PresetNotFound;
use Castor\Presets\Screencast;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\ProgressIndicator;

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

    protected function getSourceFileName()
    {
        // Detect Real file name
        $sourceFileName = realpath($this->input->getArgument('source'));

        // Check for file existence
        if (!file_exists($sourceFileName)) {
            throw new FileNotFound('Source file not found.');
        }

        return $sourceFileName;
    }

    protected function getOutputFileName($sourceFileName)
    {
        $outputFileName = $this->input->getArgument('output');
        if (!$outputFileName) {
            $outputFileName = str_replace('.mp4', '_out.mp4', $sourceFileName);
        }

        return $outputFileName;
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
        return $this->input->getOption('thumbnail');
    }

    protected function fire()
    {
        // Source file name
        $sourceFileName = $this->getSourceFileName();

        // Output file name
        $outputFileName = $this->getOutputFileName($sourceFileName);

        // Using the preset
        $outputPreset = $this->getOutputPreset();

        // Generate Thumbnail?
        $shouldGenerateThumbnail = $this->shouldGenerateThumbnail();

        $this->info("Converting: {$sourceFileName}");
        $this->info("Output File: {$outputFileName}");
        if ($shouldGenerateThumbnail) {
            $this->info('Thumbnail will be generated at the same folder');
        }

        $converter = new Converter($outputPreset, $sourceFileName, $outputFileName);


        \Castor\ProgressIndicator::setOutput($this->output);

        $this->info('');
        $converter->convert(false, true);
        $this->info('');
        $this->info('All Done :)');
    }
}
