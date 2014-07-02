<?php

namespace OpenSky\Bundle\GigyaBundle\Socializer;

class Video extends AbstractMediaItem
{
    private $previewImageUrl;
    private $previewImageHeight;
    private $previewImageWidth;

    public function __construct($src, $previewImageUrl, $previewImageWidth = null, $previewImageHeight = null, $href = null)
    {
        $this->href = $href;
        $this->previewImageUrl = $previewImageUrl;
        $this->previewImageHeight = $previewImageHeight;
        $this->previewImageWidth = $previewImageWidth;
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
     * @return string $previewImageWidth
     */
    public function getPreviewImageWidth()
    {
        return $this->previewImageWidth;
    }

    /**
     * @return string $previewImageHeight
     */
    public function getPreviewImageHeight()
    {
        return $this->previewImageHeight;
    }

    /**
     * @return array $video
     */
    public function toArray()
    {
        $array = array();
        if ($src = $this->getSrc()) {
            $array['src'] = $src;
        }
        if ($previewImageUrl = $this->getPreviewImageUrl()) {
            $array['previewImageURL'] = $previewImageUrl;
        }
        if ($previewImageWidth = $this->getPreviewImageWidth()) {
            $array['previewImageWidth'] = $previewImageWidth;
        }
        if ($previewImageHeight = $this->getPreviewImageHeight()) {
            $array['previewImageHeight'] = $previewImageHeight;
        }
        $array['type'] = $this->getType();
        return $array;
    }
}
