<?php

namespace Castor\Options\General;

use Castor\Options\ValuelessOption;

/**
 * Class Output.
 */
class Output extends ValuelessOption
{
    public function __construct($option = 'path')
    {
        parent::__construct($option);
    }
}