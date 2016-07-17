<?php

namespace Castor\Options\Thumbnail;

use Castor\Options\ValueOption;

/**
 * Class ThumbnailFilter.
 */
class ThumbnailFilter extends ValueOption
{
    public function __construct($value = 'thumbnail', $option = '-vf')
    {
        parent::__construct($value, $option);
    }
}