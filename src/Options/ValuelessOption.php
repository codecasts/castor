<?php

namespace Castor\Options;
use Castor\Contracts\Options\ValuelessOption as ValuelessOptionContract;

/**
 * Class ValuelessOption.
 */
abstract class ValuelessOption implements ValuelessOptionContract
{
    protected $option = null;

    public function __construct($option = null)
    {
        if ($option) {
            $this->option = $option;
        }
    }

    public function apply()
    {
        return [
            'option' => $this->option,
            'value'  => null,
        ];
    }
}