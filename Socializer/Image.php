<?php

namespace OpenSky\Bundle\GigyaBundle\Socializer;

class Image extends AbstractMediaItem
{
    public function __construct($src, $href = null)
    {
        $this->href = $href;
        $this->src = $src;
        $this->type = self::IMAGE;
    }

    /**
     * @return array $video
     */
    protected function toArray()
    {
        $array = array();
        if ($href = $this->getHref()) {
            $array['href'] = $href;
        }
        if ($src = $this->getSrc()) {
            $array['src'] = $src;
        }
        $array['type'] = $this->getType();
        return $array;
    }
}
