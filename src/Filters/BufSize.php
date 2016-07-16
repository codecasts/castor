<?php

/*
 * This file is part of PHP-FFmpeg.
 *
 * (c) Alchemy <dev.team@alchemy.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Castor\Filters;

use FFMpeg\Filters\Video\VideoFilterInterface;
use FFMpeg\Media\Video;
use FFMpeg\Format\VideoInterface;

class BufSize implements VideoFilterInterface
{
    protected $bufSize;

    public function __construct($bufSize)
    {
        $this->bufSize = $bufSize;
    }

    public function getPriority()
    {
        return 2;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(Video $video, VideoInterface $format)
    {
        $commands = array('-bufsize', $this->bufSize.'k');

        return $commands;
    }
}
