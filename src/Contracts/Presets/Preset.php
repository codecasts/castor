<?php

namespace Castor\Contracts\Presets;

interface Preset
{
    /**
     * @return Option|null
     */
    public function videoCodec();

    /**
     * @return Option|null
     */
    public function frameRate();

    /**
     * @return Option|null
     */
    public function bitRate();

    /**
     * @return Option|null
     */
    public function maxRate();

    /**
     * @return Option|null
     */
    public function bufSize();

    /**
     * @return Option|null
     */
    public function scale();

    /**
     * @return Option|null
     */
    public function audioCodec();

    /**
     * @return Option|null
     */
    public function audioBitRate();

    /**
     * @return Option|null
     */
    public function fastStart();

    /**
     * @return string
     */
    public function getWaterMarkFileName();
}
