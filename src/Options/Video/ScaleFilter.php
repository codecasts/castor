<?php

namespace Castor\Options\Video;

use Castor\Options\ValueOption;

/**
 * Class ScaleFilter.
 */
class ScaleFilter extends ValueOption
{
    protected $option = '-vf';

    public function __construct($value = null, $option = null)
    {
        parent::__construct('scale='.$value, $option);
    }
}