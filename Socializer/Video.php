<?php

namespace AntiMattr\GigyaBundle\Socializer;

class Video extends AbstractMediaItem
{
    private $previewImageUrl;

    public function __construct($src, $previewImageUrl, $href = null)
    {
        $this->href = $href;
        $this->previewImageUrl = $previewImageUrl;
        $this->src = $src;
        $this->type = self::VIDEO;
    }

    /**
     * @return string $previewImageUrl
     */
    public function getPreviewImageUrl()
    {
        return $this->previewImageUrl;
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
        if ($previewImageUrl = $this->getPreviewImageUrl()) {
            $array['previewImageUrl'] = $previewImageUrl;
        }
        if ($src = $this->getSrc()) {
            $array['src'] = $src;
        }
        $array['type'] = $this->getType();
        return $array;
    }
}
