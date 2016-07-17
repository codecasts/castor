<?php

namespace Castor\Options;
use Castor\Contracts\Options\ValueOption as ValueOptionContract;

/**
 * Class ValueOption.
 */
abstract class ValueOption implements ValueOptionContract
{
    protected $option = null;

    protected $value = null;

    public function __construct($value= null, $option = null)
    {
        $this->value = $value;

        if ($option) {
            $this->option = $option;
        }
    }

    public function apply()
    {
        return [
            'option' => $this->option,
            'value'  => $this->value,
        ];
    }
}