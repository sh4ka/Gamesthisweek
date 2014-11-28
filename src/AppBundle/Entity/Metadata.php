<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Metadata
 */
class Metadata
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $shortdesc;

    /**
     * @var string
     */
    private $fulldesc;

    /**
     * @var string
     */
    private $detailurl;

    /**
     * @ORM\OneToOne(targetEntity="Game")
     * @ORM\JoinColumn(name="game_id", referencedColumnName="id")
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
     * Set shortdesc
     *
     * @param string $shortdesc
     * @return Metadata
     */
    public function setShortdesc($shortdesc)
    {
        $this->shortdesc = $shortdesc;

        return $this;
    }

    /**
     * Get shortdesc
     *
     * @return string 
     */
    public function getShortdesc()
    {
        return $this->shortdesc;
    }

    /**
     * Set fulldesc
     *
     * @param string $fulldesc
     * @return Metadata
     */
    public function setFulldesc($fulldesc)
    {
        $this->fulldesc = $fulldesc;

        return $this;
    }

    /**
     * Get fulldesc
     *
     * @return string 
     */
    public function getFulldesc()
    {
        return $this->fulldesc;
    }

    /**
     * Set detailurl
     *
     * @param string $detailurl
     * @return Metadata
     */
    public function setDetailurl($detailurl)
    {
        $this->detailurl = $detailurl;

        return $this;
    }

    /**
     * Get detailurl
     *
     * @return string 
     */
    public function getDetailurl()
    {
        return $this->detailurl;
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

}
