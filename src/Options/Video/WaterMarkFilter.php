<?php

namespace Castor\Options\Video;

use Castor\Options\ValueOption;

/**
 * Class ScaleFilter.
 */
class WaterMarkFilter extends ValueOption
{
    protected $option = '-vf';

    public function __construct($value = '"movie=/tmp/castor.png [watermark]; [in][watermark] overlay=10:10 [out]"', $option = '-vf')
    {
        parent::__construct($value, $option);
    }
}