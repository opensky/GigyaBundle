<?php

namespace OpenSky\Bundle\GigyaBundle\Socializer;

class Audio extends AbstractMediaItem
{
    protected $title;
    protected $artist;
    protected $album;

    public function __construct($src, $title = null, $artist = null, $album = null, $href = null)
    {
        $this->title = $title;
        $this->artist = $artist;
        $this->album = $album;
        $this->href = $href;
        $this->src = $src;
        $this->type = self::AUDIO;
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
        if ($title = $this->getTitle()) {
            $array['title'] = $title;
        }
        if ($artist = $this->getArtist()) {
            $array['artist'] = $artist;
        }
        if ($album = $this->getAlbum()) {
            $array['album'] = $album;
        }
        $array['type'] = $this->getType();
        return $array;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getArtist()
    {
        return $this->artist;
    }

    public function getAlbum()
    {
        return $this->album;
    }

}
