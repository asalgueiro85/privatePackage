<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Notify
 *
 * @ORM\Table(name="packet_notify")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\NotifyRepository")
 */
class Notify
{
    const STATE_NEW = 1;
    const STATE_VIEW = 2;
    const TYPE_PACKET = 2;
    const TYPE_CARRY = 1;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var text
     *
     * @ORM\Column(name="notify", type="text")
     */
    private $notify;

    /**
     * @var integer
     *
     * @ORM\Column(name="state", type="integer")
     */
    private $state;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="Action", inversedBy="notifies")
     * @ORM\JoinColumn(name="action_id", referencedColumnName="id")
     */
//    /**
//     * @var integer
//     *
//     * @ORM\Column(name="action_id", type="integer")
//     */
    private $action;

    /**
     * @ORM\ManyToOne(targetEntity="Action", inversedBy="notify_final")
     * @ORM\JoinColumn(name="action_final", referencedColumnName="id")
     */
//    /**
//     * @var integer
//     *
//     * @ORM\Column(name="action_final", type="integer")
//     */
    private $action_final;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="notifies")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * Get __toString
     *
     * @return string
     */
    public function __toString()
    {
        return $this->notify;
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
     * Set notify
     *
     * @param string $notify
     *
     * @return Notify
     */
    public function setNotity($notify)
    {
        $this->notify = $notify;

        return $this;
    }

    /**
     * Get notify
     *
     * @return string
     */
    public function getNotify()
    {
        return $this->notify;
    }

    /**
     * Set state
     *
     * @param integer $state
     *
     * @return Notify
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
     * @return Notify
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
     * Set notify
     *
     * @param string $notify
     *
     * @return Notify
     */
    public function setNotify($notify)
    {
        $this->notify = $notify;

        return $this;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Notify
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
     * Set action
     *
     * @param \AppBundle\Entity\Action $action
     *
     * @return Notify
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

    /**
     * Set actionFinal
     *
     * @param \AppBundle\Entity\Action $actionFinal
     *
     * @return Notify
     */
    public function setActionFinal(\AppBundle\Entity\Action $actionFinal = null)
    {
        $this->action_final = $actionFinal;

        return $this;
    }

    /**
     * Get actionFinal
     *
     * @return \AppBundle\Entity\Action
     */
    public function getActionFinal()
    {
        return $this->action_final;
    }
}
