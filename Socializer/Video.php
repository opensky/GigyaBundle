<?php

namespace AntiMattr\GigyaBundle\Socializer;

class Video implements MediaItemInterface
{
    private $previewImageUrl;
    private $src;
    private $type;

    public function __construct($src, $previewImageUrl, $type)
    {
        $this->previewImageUrl = (string) $previewImageUrl;
        $this->src = (string) $src;
        $this->type = (string) $type;
    }

    /**
     * @return array $video
     */
    public function toArray()
    {
        $array = array();
        if ($previewImageUrl = $this->getPreviewImageUrl()) {
            $array['previewImageUrl'] = $previewImageUrl;
        }
        if ($src = $this->getSrc()) {
            $array['src'] = $src;
        }
        $array['type'] = $this->getType();
        return $array;
    }

    /**
     * @return json $video
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * @return string $previewImageUrl
     */
    public function getPreviewImageUrl()
    {
        return $this->previewImageUrl;
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
