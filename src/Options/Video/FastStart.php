<?php

namespace Castor\Options\Video;

use Castor\Options\ValueOption;

/**
 * Class FastStart.
 */
class FastStart extends ValueOption
{
    public function __construct($value = 'faststart', $option = '-movflags')
    {
        parent::__construct($value, $option);
    }
}