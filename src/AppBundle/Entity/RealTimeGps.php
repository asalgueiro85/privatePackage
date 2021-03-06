<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RealTimeGps
 *
 * @ORM\Table(name="packet_real_time_gps")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\RealTimeGpsRepository")
 */
class RealTimeGps
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="coordenate", type="string", length=255)
     */
    private $coordenate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="time", type="string", length=255)
     */
    private $time;

    /**
     * @ORM\ManyToOne(targetEntity="Action", inversedBy="RealTimeGps")
     * @ORM\JoinColumn(name="action_id", referencedColumnName="id")
     */
    private $action;
    
    /**
     * Get __toString
     *
     * @return string
     */
    public function __toString()
    {
        return $this->comments;
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
     * Set coordenate
     *
     * @param string $coordenate
     *
     * @return RealTimeGps
     */
    public function setCoordenate($coordenate)
    {
        $this->coordenate = $coordenate;

        return $this;
    }

    /**
     * Get coordenate
     *
     * @return string
     */
    public function getCoordenate()
    {
        return $this->coordenate;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return RealTimeGps
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set time
     *
     * @param string $time
     *
     * @return RealTimeGps
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return string
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set action
     *
     * @param \AppBundle\Entity\Action $action
     *
     * @return RealTimeGps
     */
    public function setAction(\AppBundle\Entity\Action $action = null)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return \AppBundle\Entity\Action
     */
    public function getAction()
    {
        return $this->action;
    }
}
