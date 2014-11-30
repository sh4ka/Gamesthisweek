<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 */
class Image
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $imageType;

    /**
     * @ORM\ManyToOne(targetEntity="Game", inversedBy="images")
     * @ORM\JoinColumn(name="game_id", referencedColumnName="id")
     * @Exclude
     **/
    private $game;


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
     * Set url
     *
     * @param string $url
     * @return Image
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * <description>
     *
     * @param mixed $game <param_description>
     *
     * @return $this
     */
    public function setGame($game)
    {
        $this->game = $game;
        return $this;
    }

    /**
     * <description>
     *
     * @return mixed
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * <description>
     *
     * @param string $imageType <param_description>
     *
     * @return $this
     */
    public function setImageType($imageType)
    {
        $this->imageType = $imageType;
        return $this;
    }

    /**
     * <description>
     *
     * @return string
     */
    public function getImageType(){
        return $this->imageType;
    }




}
