<?php

namespace AntiMattr\GigyaBundle\Socializer;

class ActionLink
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
}
