<?php

namespace Castor\Contracts\Options;

/**
 * Interface Option.
 */
interface Option
{
    /**
     * @return array
     */
    public function apply();
}