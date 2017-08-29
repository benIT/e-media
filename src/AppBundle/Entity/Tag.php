<?php

namespace AppBundle\Entity;

/**
 * Tag
 */
class Tag
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $restricted;


    private $videos;

    /**
     * @return mixed
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * @param mixed $videos
     */
    public function setVideos($videos)
    {
        $this->videos = $videos;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Tag
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set restricted
     *
     * @param boolean $restricted
     *
     * @return Tag
     */
    public function setRestricted($restricted)
    {
        $this->restricted = $restricted;

        return $this;
    }

    /**
     * Get restricted
     *
     * @return bool
     */
    public function getRestricted()
    {
        return $this->restricted;
    }

    public function __construct()
    {
        $this->videos = new \Doctrine\Common\Collections\ArrayCollection();
    }

}

