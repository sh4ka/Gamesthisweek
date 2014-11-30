<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Platform
 */
class Platform
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
    private $externalId;


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
     * @return Platform
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
     * <description>
     *
     * @return int
     */
    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * <description>
     *
     * @param int $externalId <param_description>
     *
     * @return $this
     */
    public function setExternalId($externalId)
    {
        $this->externalId = $externalId;
        return $this;
    }

}
