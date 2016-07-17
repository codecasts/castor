<?php

namespace Castor\Presets;

/**
 * Class H264.
 */
class H264 extends Preset
{
    protected $videoCodec = 'libx264';

    protected $audioCodec = 'aac';

    protected $fastStart = true;
}