<?php

namespace Castor\Presets;

use Castor\Contracts\Presets\Preset as PresetContract;

/**
 * Class Screencast.
 *
 * Screencast preset to archive lower file size and fast loading
 * on players.
 */
class Screencast extends Preset implements PresetContract
{
    /**
     * @var int Smaller FPS for screencasts.
     */
    protected $framesPerSecond = 15;

    /**
     * @var array Defaults a screencast to 720p.
     */
    protected $dimensions = [1280, 720];

    /**
     * @var int Smaller Video BitRate for web.
     */
    protected $kiloBitRate = 600;

    /**
     * @var int Smaller Audio BitRate for web.
     */
    protected $audioKiloBitRate = 128;
}
