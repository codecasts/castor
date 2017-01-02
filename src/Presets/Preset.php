<?php

namespace Castor\Presets;

use Castor\Contracts\Options\Option;
use Castor\Contracts\Presets\Preset as PresetContract;
use Castor\Options\Audio\AudioBitRate;
use Castor\Options\Audio\AudioCodec;
use Castor\Options\Video\BitRate;
use Castor\Options\Video\BufSize;
use Castor\Options\Video\FastStart;
use Castor\Options\Video\FrameRate;
use Castor\Options\Video\MaxRate;
use Castor\Options\Video\ScaleFilter;
use Castor\Options\Video\VideoCodec;

/**
 * Class Preset.
 *
 * Abstract preset class in which the usable presets should be based.
 */
abstract class Preset implements PresetContract
{
    protected $videoCodec = null;

    protected $frameRate = null;

    protected $bitRate = null;

    protected $maxRate = null;

    protected $audioCodec = null;

    protected $scale = null;

    protected $audioBitRate = null;

    protected $fastStart = true;

    protected $waterMarkFile = null;

    /**
     * @param $value
     * @param $class
     * @param bool $kiloBit
     * @return Option|null
     */
    protected function optionOrNull($value, $class, $kiloBit = false)
    {
        if ($value) {
            if ($kiloBit) {

                return new $class($value.'k');
            }

            return new $class($value);
        }

        return null;
    }

    /**
     * @return Option|null
     */
    public function videoCodec()
    {
        return $this->optionOrNull($this->videoCodec, VideoCodec::class);
    }

    /**
     * @return Option|null
     */
    public function frameRate()
    {
        return $this->optionOrNull($this->frameRate, FrameRate::class);
    }

    /**
     * @return Option|null
     */
    public function bitRate()
    {
        return $this->optionOrNull($this->bitRate, BitRate::class, true);
    }

    /**
     * @return Option|null
     */
    public function maxRate()
    {
        return $this->optionOrNull($this->maxRate, MaxRate::class, true);
    }

    /**
     * @return Option|null
     */
    public function bufSize()
    {
        $bufSize = $this->bitRate ? (2 * $this->bitRate) : null;

        return $this->optionOrNull($bufSize, BufSize::class, true);
    }

    /**
     * @return Option|null
     */
    public function scale()
    {
        return $this->optionOrNull($this->scale, ScaleFilter::class);
    }

    /**
     * @return Option|null
     */
    public function audioCodec()
    {
        return $this->optionOrNull($this->audioCodec, AudioCodec::class);
    }

    /**
     * @return Option|null
     */
    public function audioBitRate()
    {
        return $this->optionOrNull($this->audioBitRate, AudioBitRate::class, true);
    }

    public function fastStart()
    {
        if ($this->fastStart) {
            return new FastStart();
        }

        return null;
    }

    public function getWaterMarkFileName()
    {
        return $this->waterMarkFile;
    }
}
