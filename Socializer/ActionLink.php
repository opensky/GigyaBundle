<?php

namespace OpenSky\Bundle\GigyaBundle\Socializer;

class ActionLink extends AbstractMediaItem
{
    private $destination;
    private $title;

    public function __construct($title, $destination)
    {
        $this->destination = (string) $destination;
        $this->title = (string) $title;
    }

    /**
     * @return string $destination
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return array $link
     */
    public function toArray()
    {
        $array = array();
        if ($destination = $this->getDestination()) {
            $array['href'] = $destination;
        }
        if ($title = $this->getTitle()) {
            $array['text'] = $title;
        }
        return $array;
    }
}
