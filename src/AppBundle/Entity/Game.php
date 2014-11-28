<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;

/**
 * Game
 */
class Game
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $releaseDay;

    /**
     * @var integer
     */
    private $releaseMonth;

    /**
     * @var integer
     */
    private $releaseYear;

    /**
     * @var string
     */
    private $detailsUrl;

    /**
     * @ORM\ManyToOne(targetEntity="Platform")
     * @ORM\JoinColumn(name="platform_id", referencedColumnName="id")
     * @Exclude
     **/
    private $platform;

    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="game")
     **/
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Game
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
     * Set releaseDay
     *
     * @param integer $releaseDay
     * @return Game
     */
    public function setReleaseDay($releaseDay)
    {
        $this->releaseDay = $releaseDay;

        return $this;
    }

    /**
     * Get releaseDay
     *
     * @return integer 
     */
    public function getReleaseDay()
    {
        return $this->releaseDay;
    }

    /**
     * Set releaseMonth
     *
     * @param integer $releaseMonth
     * @return Game
     */
    public function setReleaseMonth($releaseMonth)
    {
        $this->releaseMonth = $releaseMonth;

        return $this;
    }

    /**
     * Get releaseMonth
     *
     * @return integer 
     */
    public function getReleaseMonth()
    {
        return $this->releaseMonth;
    }

    /**
     * Set releaseYear
     *
     * @param integer $releaseYear
     * @return Game
     */
    public function setReleaseYear($releaseYear)
    {
        $this->releaseYear = $releaseYear;

        return $this;
    }

    /**
     * Get releaseYear
     *
     * @return integer 
     */
    public function getReleaseYear()
    {
        return $this->releaseYear;
    }

    /**
     * <description>
     *
     * @param mixed $platform <param_description>
     *
     * @return $this
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;
        return $this;
    }

    /**
     * <description>
     *
     * @return mixed
     */
    public function getPlatform(){
        return $this->platform;
    }

    /**
     * <description>
     *
     * @param mixed $images <param_description>
     *
     * @return $this
     */
    public function setImages($images)
    {
        $this->images = $images;
        return $this;
    }

    /**
     * <description>
     *
     * @return mixed
     */
    public function getImages(){
        return $this->images;
    }

    /**
     * <description>
     *
     * @param string $detailsUrl <param_description>
     *
     * @return $this
     */
    public function setDetailsUrl($detailsUrl)
    {
        $this->detailsUrl = $detailsUrl;
        return $this;
    }

    /**
     * <description>
     *
     * @return string
     */
    public function getDetailsUrl()
    {
        return $this->detailsUrl;
    }



}
