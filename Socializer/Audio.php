<?php

namespace OpenSky\Bundle\GigyaBundle\Socializer;

class Audio extends AbstractMediaItem
{
    public function __construct($src, $href = null)
    {
        $this->href = $href;
        $this->src = $src;
        $this->type = self::AUDIO;
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
