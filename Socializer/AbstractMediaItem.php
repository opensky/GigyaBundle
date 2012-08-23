<?php

namespace OpenSky\Bundle\GigyaBundle\Socializer;

abstract class AbstractMediaItem implements MediaItemInterface
{
    protected $href;
    protected $src;
    protected $type;

    /**
     * @return array $mediaItem
     */
    abstract public function toArray();

    /**
     * @return json $video
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * @return string $href
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @return string $src
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * @return string $string
     */
    public function getType()
    {
        return $this->type;
    }
}
