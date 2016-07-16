<?php

namespace Castor;

use Castor\Contracts\Presets\Preset;
use Castor\Filters\MaxRate;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use FFMpeg\Format\FormatInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Converter
{
    protected $sourceFilePath;

    protected $destinationFilePath;

    protected $preset;

    public function __construct(Preset $preset, $sourceFilePath, $destinationFilePath)
    {
        $this->sourceFilePath = $sourceFilePath;

        $this->destinationFilePath = $destinationFilePath;

        $this->preset = $preset;
    }

    public function convert($keepProportions = false, $thumbnail = false)
    {
        $this->convertVideo($keepProportions);

        if ($thumbnail) {
            $this->generateThumbnail();
        }
    }

    protected function convertVideo($keepProportions = false)
    {
        $video = $this->getFFMpeg()
            ->open($this->sourceFilePath);


        if (!$keepProportions) {
            $video->filters()->resize($this->preset->getDimensions());
        }

        $video->filters()->framerate($this->preset->getFrameRate(), 15);

        $video->addFilter($this->preset->getMaxKiloBitRateFilter());
        $video->addFilter($this->preset->getBufSizeFilter());

        $outputFormat = $this->preset->getOutputFormat();

        $outputFormat->on('progress', function($video, $output, $progress) {
            $instance = ProgressIndicator::instance();
            $instance->setProgress($progress);
        });

        $video->save($outputFormat, $this->destinationFilePath);
    }

    protected function generateThumbnail()
    {
        $video = $this->getFFMpeg()->open($this->destinationFilePath);

        $video
            ->frame(TimeCode::fromSeconds(60))
            ->save(str_replace('.mp4', '.jpg', $this->destinationFilePath));
    }

    /**
     * @return FFMpeg
     */
    protected function getFFMpeg()
    {
        return FFMpeg::create();
    }
}
