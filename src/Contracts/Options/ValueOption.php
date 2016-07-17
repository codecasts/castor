<?php

namespace Castor\Contracts\Options;

/**
 * Interface ValueOption.
 */
interface ValueOption extends Option
{
    public function __construct($value = null, $option = null);
}