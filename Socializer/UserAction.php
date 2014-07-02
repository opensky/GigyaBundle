<?php

namespace OpenSky\Bundle\GigyaBundle\Socializer;

class UserAction
{
    private $actionLinks = array();
    private $description;
    private $linkBack;
    private $mediaItems = array();
    private $title;
    private $userMessage;

    /**
     * convert UserAction object to Json object
     */
    public function toJson()
    {
        $userAction = array();

        if (null != $this->getUserMessage()) {
            $userAction['userMessage'] = $this->getUserMessage();
        }

        if (null != $this->getTitle()) {
            $userAction['title'] = $this->getTitle();
        }

        if (null != $this->getLinkBack()) {
            $userAction['linkBack'] = $this->getLinkBack();
        }

        if (null != $this->getDescription()) {
            $userAction['description'] = $this->getDescription();
        }

        if (null != $this->actionLinks) {
            $userAction['actionLinks'] = array();
            foreach($this->actionLinks as $a) {
                array_push($userAction['actionLinks'], $a->toArray());
            }
        }

        if (null != $this->mediaItems) {
            // note that you can only share one media type at once
            $userAction['mediaItems'] = array();
            foreach($this->mediaItems as $m) {
                array_push($userAction['mediaItems'], $m->toArray());
            }
        }

        return json_encode($userAction);
    }

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
