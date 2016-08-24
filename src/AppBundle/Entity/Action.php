<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Action
 *
 * @ORM\Table(name="packet_action")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ActionRepository")
 */
class Action
{
    const UNKNOWN = 0;
    const OPEN = 1;
    const UPCOMING = 2;
    const SHIPPED = 3;
    const ARCHIVED = 4;
    const REMOVE = 5;
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
     * @ORM\Column(name="coordenate_from", type="string", length=255, nullable=true)
     */
    private $coordenateFrom;

    /**
     * @var string
     *
     * @ORM\Column(name="coordenate_to", type="string", length=255, nullable=true)
     */
    private $coordenateTo;

    /**
     * @var date
     *
     * @ORM\Column(name="date_from", type="date")
     */
    private $dateFrom;

    /**
 * @var date
 *
 * @ORM\Column(name="date_to", type="date")
 */
    private $dateTo;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", nullable=true)
     */
    private $price;

    /**
     * @var float
     *
     * @ORM\Column(name="weight", type="float", nullable=true)
     */
    private $weight;

    /**
     * @var string
     *
     * @ORM\Column(name="volumen", type="string", nullable=true)
     */
    private $volumen;

    /**
     * @var text
     *
     * @ORM\Column(name="observation", type="text", nullable=true)
     */
    private $observation;

    /**
     * @var boolean
     *
     * @ORM\Column(name="charity", type="boolean", nullable=true)
     */
    private $caridad = false;

    /**
     * @var integer
     *
     * @ORM\Column(name="state", type="integer")
     */
    private $state = Action::OPEN;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="carry_type", type="string", length=255, nullable=true)
     */
    private $carryType;

    /**
     * @var string
     *
     * @ORM\Column(name="packet_name", type="string", length=255, nullable=true)
     */
    private $packetName;

    /**
     * @var string
     *
     * @ORM\Column(name="path_picture", type="string", length=255, nullable=true)
     */
    private $pathPicture;

    /**
     * @Assert\Image(maxSize = "1000k")
     */
    private $picture;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="actions")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Direction", inversedBy="action",cascade={"persist","remove"})
     * @ORM\JoinColumn(name="direction_id", referencedColumnName="id")
     */
    private $direction;

    /**
     * @ORM\OneToMany(targetEntity="Action", mappedBy="carry", cascade={"persist"})
     */
    private $packet;

    /**
     * @ORM\ManyToOne(targetEntity="Action", inversedBy="packet", cascade={"persist"})
     * @ORM\JoinColumn(name="carry_id", referencedColumnName="id")
     */
    private $carry;

    /**
     * @ORM\OneToMany(targetEntity="RealTimeGps", mappedBy="action")
     */
    private $RealTimeGps;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Notify", mappedBy="action", cascade={"remove"})
     */
    private $notifies;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Notify", mappedBy="action_final", cascade={"remove"})
     */
    private $notify_final;

    /**
     * @ORM\OneToMany(targetEntity="Comments", mappedBy="action")
     */
    private $comments;


    /**
     *
     * @ORM\ManyToMany(targetEntity="Action", inversedBy="packetRequest", cascade={"persist"})
     * @ORM\JoinTable(name="packet_request",
     * joinColumns={@ORM\JoinColumn(name="packet_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="carry_id", referencedColumnName="id")})
     */
    private $carryRequest;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Action", mappedBy="carryRequest", cascade={"persist"})
     */
    private $packetRequest;



    /**
     * @param UploadedFile $picture
     */
    public function setPicture(UploadedFile $picture = null)
    {
        $this->picture = $picture;
    }


    /**
     * @return UploadedFile
     */
    public function getPicture()
    {
        return $this->picture;
    }
    /**
     *
     * @return string
     */
    public function __toString(){
        return 'Action';
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->packet = new \Doctrine\Common\Collections\ArrayCollection();
        $this->RealTimeGps = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->carryRequest = new \Doctrine\Common\Collections\ArrayCollection();
        $this->packetRequest = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set coordenateFrom
     *
     * @param string $coordenateFrom
     *
     * @return Action
     */
    public function setCoordenateFrom($coordenateFrom)
    {
        $this->coordenateFrom = $coordenateFrom;

        return $this;
    }

    /**
     * Get coordenateFrom
     *
     * @return string
     */
    public function getCoordenateFrom()
    {
        return $this->coordenateFrom;
    }

    /**
     * Set coordenateTo
     *
     * @param string $coordenateTo
     *
     * @return Action
     */
    public function setCoordenateTo($coordenateTo)
    {
        $this->coordenateTo = $coordenateTo;

        return $this;
    }

    /**
     * Get coordenateTo
     *
     * @return string
     */
    public function getCoordenateTo()
    {
        return $this->coordenateTo;
    }

    /**
     * Set dateFrom
     *
     * @param \DateTime $dateFrom
     *
     * @return Action
     */
    public function setDateFrom($dateFrom)
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    /**
     * Get dateFrom
     *
     * @return \DateTime
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * Set dateTo
     *
     * @param \DateTime $dateTo
     *
     * @return Action
     */
    public function setDateTo($dateTo)
    {
        $this->dateTo = $dateTo;

        return $this;
    }

    /**
     * Get dateTo
     *
     * @return \DateTime
     */
    public function getDateTo()
    {
        return $this->dateTo;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Action
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set weight
     *
     * @param float $weight
     *
     * @return Action
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set volumen
     *
     * @param string $volumen
     *
     * @return Action
     */
    public function setVolumen($volumen)
    {
        $this->volumen = $volumen;

        return $this;
    }

    /**
     * Get volumen
     *
     * @return string
     */
    public function getVolumen()
    {
        return $this->volumen;
    }

    /**
     * Set observation
     *
     * @param string $observation
     *
     * @return Action
     */
    public function setObservation($observation)
    {
        $this->observation = $observation;

        return $this;
    }

    /**
     * Get observation
     *
     * @return string
     */
    public function getObservation()
    {
        return $this->observation;
    }

    /**
     * Set caridad
     *
     * @param boolean $caridad
     *
     * @return Action
     */
    public function setCaridad($caridad)
    {
        $this->caridad = $caridad;

        return $this;
    }

    /**
     * Get caridad
     *
     * @return boolean
     */
    public function getCaridad()
    {
        return $this->caridad;
    }

    /**
     * Set state
     *
     * @param integer $state
     *
     * @return Action
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return integer
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return Action
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set carryType
     *
     * @param string $carryType
     *
     * @return Action
     */
    public function setCarryType($carryType)
    {
        $this->carryType = $carryType;

        return $this;
    }

    /**
     * Get carryType
     *
     * @return string
     */
    public function getCarryType()
    {
        return $this->carryType;
    }

    /**
     * Set packetName
     *
     * @param string $packetName
     *
     * @return Action
     */
    public function setPacketName($packetName)
    {
        $this->packetName = $packetName;

        return $this;
    }

    /**
     * Get packetName
     *
     * @return string
     */
    public function getPacketName()
    {
        return $this->packetName;
    }

    /**
     * Set pathPicture
     *
     * @param string $pathPicture
     *
     * @return Action
     */
    public function setPathPicture($pathPicture)
    {
        $this->pathPicture = $pathPicture;

        return $this;
    }

    /**
     * Get pathPicture
     *
     * @return string
     */
    public function getPathPicture()
    {
        return $this->pathPicture;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Action
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set direction
     *
     * @param \AppBundle\Entity\Direction $direction
     *
     * @return Action
     */
    public function setDirection(\AppBundle\Entity\Direction $direction = null)
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * Get direction
     *
     * @return \AppBundle\Entity\Direction
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * Add packet
     *
     * @param \AppBundle\Entity\Action $packet
     *
     * @return Action
     */
    public function addPacket(\AppBundle\Entity\Action $packet)
    {
        $this->packet[] = $packet;

        return $this;
    }

    /**
     * Remove packet
     *
     * @param \AppBundle\Entity\Action $packet
     */
    public function removePacket(\AppBundle\Entity\Action $packet)
    {
        $this->packet->removeElement($packet);
    }

    /**
     * Get packet
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPacket()
    {
        return $this->packet;
    }

    /**
     * Set carry
     *
     * @param \AppBundle\Entity\Action $carry
     *
     * @return Action
     */
    public function setCarry(\AppBundle\Entity\Action $carry = null)
    {
        $this->carry = $carry;

        return $this;
    }

    /**
     * Get carry
     *
     * @return \AppBundle\Entity\Action
     */
    public function getCarry()
    {
        return $this->carry;
    }

    /**
     * Add realTimeGp
     *
     * @param \AppBundle\Entity\RealTimeGps $realTimeGp
     *
     * @return Action
     */
    public function addRealTimeGp(\AppBundle\Entity\RealTimeGps $realTimeGp)
    {
        $this->RealTimeGps[] = $realTimeGp;

        return $this;
    }

    /**
     * Remove realTimeGp
     *
     * @param \AppBundle\Entity\RealTimeGps $realTimeGp
     */
    public function removeRealTimeGp(\AppBundle\Entity\RealTimeGps $realTimeGp)
    {
        $this->RealTimeGps->removeElement($realTimeGp);
    }

    /**
     * Get realTimeGps
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRealTimeGps()
    {
        return $this->RealTimeGps;
    }

    /**
     * Add comment
     *
     * @param \AppBundle\Entity\Comments $comment
     *
     * @return Action
     */
    public function addComment(\AppBundle\Entity\Comments $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \AppBundle\Entity\Comments $comment
     */
    public function removeComment(\AppBundle\Entity\Comments $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add carryRequest
     *
     * @param \AppBundle\Entity\Action $carryRequest
     *
     * @return Action
     */
    public function addCarryRequest(\AppBundle\Entity\Action $carryRequest)
    {
        $this->carryRequest[] = $carryRequest;

        return $this;
    }

    /**
     * Remove carryRequest
     *
     * @param \AppBundle\Entity\Action $carryRequest
     */
    public function removeCarryRequest(\AppBundle\Entity\Action $carryRequest)
    {
        $this->carryRequest->removeElement($carryRequest);
    }

    /**
     * Get carryRequest
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCarryRequest()
    {
        return $this->carryRequest;
    }

    /**
     * Add packetRequest
     *
     * @param \AppBundle\Entity\Action $packetRequest
     *
     * @return Action
     */
    public function addPacketRequest(\AppBundle\Entity\Action $packetRequest)
    {
        $this->packetRequest[] = $packetRequest;

        return $this;
    }

    /**
     * Remove packetRequest
     *
     * @param \AppBundle\Entity\Action $packetRequest
     */
    public function removePacketRequest(\AppBundle\Entity\Action $packetRequest)
    {
        $this->packetRequest->removeElement($packetRequest);
    }

    /**
     * Get packetRequest
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPacketRequest()
    {
        return $this->packetRequest;
    }

    /**
     * Add notify
     *
     * @param \AppBundle\Entity\Notify $notify
     *
     * @return Action
     */
    public function addNotify(\AppBundle\Entity\Notify $notify)
    {
        $this->notifies[] = $notify;

        return $this;
    }

    /**
     * Remove notify
     *
     * @param \AppBundle\Entity\Notify $notify
     */
    public function removeNotify(\AppBundle\Entity\Notify $notify)
    {
        $this->notifies->removeElement($notify);
    }

    /**
     * Get notifies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotifies()
    {
        return $this->notifies;
    }

    /**
     * Add notifyFinal
     *
     * @param \AppBundle\Entity\Notify $notifyFinal
     *
     * @return Action
     */
    public function addNotifyFinal(\AppBundle\Entity\Notify $notifyFinal)
    {
        $this->notify_final[] = $notifyFinal;

        return $this;
    }

    /**
     * Remove notifyFinal
     *
     * @param \AppBundle\Entity\Notify $notifyFinal
     */
    public function removeNotifyFinal(\AppBundle\Entity\Notify $notifyFinal)
    {
        $this->notify_final->removeElement($notifyFinal);
    }

    /**
     * Get notifyFinal
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotifyFinal()
    {
        return $this->notify_final;
    }
}
