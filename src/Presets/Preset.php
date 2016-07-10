<?php

namespace Castor\Presets;

use Castor\Contracts\Presets\Preset as PresetContract;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Coordinate\FrameRate;
use FFMpeg\Format\Video\X264;

/**
 * Class Preset.
 * 
 * Abstract preset class in which the usable presets should be based.
 */
abstract class Preset implements PresetContract
{
    /**
     * @var int Frame Rate (FPS = Frames per Second).
     */
    protected $framesPerSecond = 30;

    /**
     * @var array Output video resolution.
     */
    protected $dimensions = [1980, 1280];

    /**
     * @var string Video Codec.
     */
    protected $videoCodec = 'libx264';

    /**
     * @var string Audio Codec.
     */
    protected $audioCodec = 'libfaac';

    /**
     * @var int Video BitRate in Kb.
     */
    protected $kiloBitRate = 5000;

    /**
     * @var int Audio BitRate in Kb.
     */
    protected $audioKiloBitRate = 256;

    /**
     * @var int Number or audio channels.
     */
    protected $audioChannels = 2;

    /**
     * @return X264 The output settings.
     */
    public function getOutputFormat()
    {
        $outputFormat = new X264();
        $outputFormat
            ->setVideoCodec($this->videoCodec)
            ->setAudioCodec($this->audioCodec)
            ->setKiloBitrate($this->kiloBitRate)
            ->setAudioKiloBitrate($this->audioKiloBitRate)
            ->setAudioChannels($this->audioChannels);

        return $outputFormat;
    }

    /**
     * @return FrameRate Output FPS.
     */
    public function getFrameRate()
    {
        return new FrameRate($this->framesPerSecond);
    }

    /**
     * @return Dimension Output dimensions (resolution).
     */
    public function getDimensions()
    {
        return new Dimension($this->dimensions[0], $this->dimensions[1]);
    }
}
