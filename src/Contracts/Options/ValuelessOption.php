<?php

namespace Castor\Contracts\Options;

/**
 * Interface ValuelessOption.
 */
interface ValuelessOption extends Option
{
    public function __construct($option = null);
}