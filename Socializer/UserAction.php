<?php

namespace AntiMattr\GigyaBundle\Socializer;

class UserAction
{
    private $actionLinks = array();
    private $description;
    private $linkBack;
    private $mediaItems = array();
    private $title;
    private $userMessage;

    /**
     * @param ActionLink $actionLink
     */
    public function addActionLink(ActionLink $actionLink)
    {
        $this->actionLinks[] = $actionLink;
    }

    /**
     * @return array $actionLinks
     */
    public function getActionLinks()
    {
        return $this->actionLinks;
    }

    /**
     * @param ActionLink $actionLink
     * @return boolean $hasActionLink
     */
    public function hasActionLink(ActionLink $actionLink)
    {
        return in_array($actionLink, $this->actionLinks, true);
    }

    /**
     * @return boolean $hasActionLinks
     */
    public function hasActionLinks()
    {
        if (!empty($this->actionLinks)) {
            return true;
        }
        return false;
    }

    /**
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = (string) $description;
    }

    /**
     * @return string $linkBack
     */
    public function getLinkBack()
    {
        return $this->linkBack;
    }

    /**
     * @param string $linkBack
     */
    public function setLinkBack($linkBack)
    {
        $this->linkBack = $linkBack;
    }

    /**
     * @param MediaItemInterface $mediaItem
     */
    public function addMediaItem(MediaItemInterface $mediaItem)
    {
        $this->mediaItems[] = $mediaItem;
    }

    /**
     * @return array $mediaItems
     */
    public function getMediaItems()
    {
        return $this->mediaItems;
    }

    /**
     * @param MediaItemInterface $mediaItem
     * @return boolean $hasMediaItem
     */
    public function hasMediaItem(MediaItemInterface $mediaItem)
    {
        return in_array($mediaItem, $this->mediaItems, true);
    }

    /**
     * @return boolean $hasMediaItems
     */
    public function hasMediaItems()
    {
        if (!empty($this->mediaItems)) {
            return true;
        }
        return false;
    }

    /**
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = (string) $title;
    }

    /**
     * @return string $userMessage
     */
    public function getUserMessage()
    {
        return $this->userMessage;
    }

    /**
     * @param string $userMessage
     */
    public function setUserMessage($userMessage)
    {
        $this->userMessage = (string) $userMessage;
    }
}
