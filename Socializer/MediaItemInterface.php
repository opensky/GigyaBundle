<?php

namespace OpenSky\Bundle\GigyaBundle\Socializer;

interface MediaItemInterface
{
    const IMAGE = 'image';
    const AUDIO = 'mp3';
    const VIDEO = 'flash';

    /**
     * @return $mediaItem
     */
    public function toJson();

    /**
     * @return string $type
     */
    public function getType();
}
