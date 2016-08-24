<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Direction
 *
 * @ORM\Table(name="packet_direction")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\DirectionRepository")
 */
class Direction
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
 * @ORM\Column(name="country_from", type="string", length=255)
 */
    private $countryFrom;

    /**
     * @var string
     *
     * @ORM\Column(name="city_from", type="string", length=255)
     */
    private $cityFrom;

    /**
     * @var string
     *
     * @ORM\Column(name="state_from", type="string", length=255)
     */
    private $stateFrom;

    /**
     * @var string
     *
     * @ORM\Column(name="zip_code_from", type="string", length=10, nullable=true)
     */
    private $zipCodeFrom;

    /**
     * @var string
     *
     * @ORM\Column(name="number_from", type="string", length=10, nullable=true)
     */
    private $numberFrom;

    /**
     * @var string
     *
     * @ORM\Column(name="floor_from", type="string", length=10, nullable=true)
     */
    private $floorFrom;

    /**
     * @var string
     *
     * @ORM\Column(name="country_to", type="string", length=255,)
     */
    private $countryTo;

    /**
     * @var string
     *
     * @ORM\Column(name="city_to", type="string", length=255)
     */
    private $cityTo;

    /**
     * @var string
     *
     * @ORM\Column(name="state_to", type="string", length=255)
     */
    private $stateTo;

    /**
     * @var string
     *
     * @ORM\Column(name="zip_code_to", type="string", length=10, nullable=true)
     */
    private $zipCodeTo;

    /**
     * @var string
     *
     * @ORM\Column(name="number_to", type="string", length=10, nullable=true)
     */
    private $numberTo;

    /**
     * @var string
     *
     * @ORM\Column(name="floor_to", type="string", length=10, nullable=true)
     */
    private $floorTo;

      /**
     * @ORM\OneToOne(targetEntity="Action", mappedBy="direction", cascade={"persist","remove"})
     */
    private $action;


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
     * Set countryFrom
     *
     * @param string $countryFrom
     *
     * @return Direction
     */
    public function setCountryFrom($countryFrom)
    {
        $this->countryFrom = $countryFrom;

        return $this;
    }

    /**
     * Get countryFrom
     *
     * @return string
     */
    public function getCountryFrom()
    {
        return $this->countryFrom;
    }

    /**
     * Set cityFrom
     *
     * @param string $cityFrom
     *
     * @return Direction
     */
    public function setCityFrom($cityFrom)
    {
        $this->cityFrom = $cityFrom;

        return $this;
    }

    /**
     * Get cityFrom
     *
     * @return string
     */
    public function getCityFrom()
    {
        return $this->cityFrom;
    }

    /**
     * Set stateFrom
     *
     * @param string $stateFrom
     *
     * @return Direction
     */
    public function setStateFrom($stateFrom)
    {
        $this->stateFrom = $stateFrom;

        return $this;
    }

    /**
     * Get stateFrom
     *
     * @return string
     */
    public function getStateFrom()
    {
        return $this->stateFrom;
    }

    /**
     * Set zipCodeFrom
     *
     * @param string $zipCodeFrom
     *
     * @return Direction
     */
    public function setZipCodeFrom($zipCodeFrom)
    {
        $this->zipCodeFrom = $zipCodeFrom;

        return $this;
    }

    /**
     * Get zipCodeFrom
     *
     * @return string
     */
    public function getZipCodeFrom()
    {
        return $this->zipCodeFrom;
    }

    /**
     * Set numberFrom
     *
     * @param string $numberFrom
     *
     * @return Direction
     */
    public function setNumberFrom($numberFrom)
    {
        $this->numberFrom = $numberFrom;

        return $this;
    }

    /**
     * Get numberFrom
     *
     * @return string
     */
    public function getNumberFrom()
    {
        return $this->numberFrom;
    }

    /**
     * Set floorFrom
     *
     * @param string $floorFrom
     *
     * @return Direction
     */
    public function setFloorFrom($floorFrom)
    {
        $this->floorFrom = $floorFrom;

        return $this;
    }

    /**
     * Get floorFrom
     *
     * @return string
     */
    public function getFloorFrom()
    {
        return $this->floorFrom;
    }

    /**
     * Set countryTo
     *
     * @param string $countryTo
     *
     * @return Direction
     */
    public function setCountryTo($countryTo)
    {
        $this->countryTo = $countryTo;

        return $this;
    }

    /**
     * Get countryTo
     *
     * @return string
     */
    public function getCountryTo()
    {
        return $this->countryTo;
    }

    /**
     * Set cityTo
     *
     * @param string $cityTo
     *
     * @return Direction
     */
    public function setCityTo($cityTo)
    {
        $this->cityTo = $cityTo;

        return $this;
    }

    /**
     * Get cityTo
     *
     * @return string
     */
    public function getCityTo()
    {
        return $this->cityTo;
    }

    /**
     * Set stateTo
     *
     * @param string $stateTo
     *
     * @return Direction
     */
    public function setStateTo($stateTo)
    {
        $this->stateTo = $stateTo;

        return $this;
    }

    /**
     * Get stateTo
     *
     * @return string
     */
    public function getStateTo()
    {
        return $this->stateTo;
    }

    /**
     * Set zipCodeTo
     *
     * @param string $zipCodeTo
     *
     * @return Direction
     */
    public function setZipCodeTo($zipCodeTo)
    {
        $this->zipCodeTo = $zipCodeTo;

        return $this;
    }

    /**
     * Get zipCodeTo
     *
     * @return string
     */
    public function getZipCodeTo()
    {
        return $this->zipCodeTo;
    }

    /**
     * Set numberTo
     *
     * @param string $numberTo
     *
     * @return Direction
     */
    public function setNumberTo($numberTo)
    {
        $this->numberTo = $numberTo;

        return $this;
    }

    /**
     * Get numberTo
     *
     * @return string
     */
    public function getNumberTo()
    {
        return $this->numberTo;
    }

    /**
     * Set floorTo
     *
     * @param string $floorTo
     *
     * @return Direction
     */
    public function setFloorTo($floorTo)
    {
        $this->floorTo = $floorTo;

        return $this;
    }

    /**
     * Get floorTo
     *
     * @return string
     */
    public function getFloorTo()
    {
        return $this->floorTo;
    }

     /**
     * Set action
     *
     * @param \AppBundle\Entity\Action $action
     *
     * @return Direction
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
