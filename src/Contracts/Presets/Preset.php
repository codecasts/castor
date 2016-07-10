<?php

namespace Castor\Contracts\Presets;

interface Preset
{
    public function getOutputFormat();

    public function getFrameRate();

    public function getDimensions();
}
