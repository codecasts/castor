<?php

namespace Castor\Presets;

use Castor\Contracts\Presets\Preset as PresetContract;

/**
 * Class Screencast.
 *
 * Screencast preset to archive lower file size and fast loading
 * on players.
 */
class Screencast extends H264 implements PresetContract
{
    /**
     * @var int Lower FPS.
     */
    protected $frameRate = 15;

    /**
     * @var int Low BitRate
     */
    protected $bitRate = 1000;

    /**
     * @var int Max and BitRate should be the same.
     */
    protected $maxRate = 1000;

    /**
     * @var string Defaults to 720p
     */
    protected $scale = '1280:720';

    /**
     * @var int 128 is enough.
     */
    protected $audioBitRate = 128;
}
