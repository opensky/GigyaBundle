<?php

namespace AntiMattr\GigyaBundle\Socializer;

interface MediaItemInterface
{
    const FLASH = 'flash';

    /**
     * @return array $mediaItem
     */
    public function toArray();

    /**
     * @return json $mediaItem
     */
    public function toJson();

    /**
     * @return string $type
     */
    public function getType();
}
