<?php

namespace Castor\Options\Thumbnail;

use Castor\Options\ValueOption;

/**
 * Class Frames.
 */
class Frames extends ValueOption
{
    public function __construct($value = '1', $option = '-frames:v')
    {
        parent::__construct($value, $option);
    }
}