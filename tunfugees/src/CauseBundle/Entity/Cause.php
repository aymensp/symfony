<?php

namespace CauseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cause
 *
 * @ORM\Table(name="cause")
 * @ORM\Entity(repositoryClass="CauseBundle\Repository\CauseRepository")
 */
class Cause
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="img", type="string", length=255)
     */
    private $img;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="goals", type="integer", nullable=false)
     */
    private $goals;

    /**
     * @var integer
     *
     * @ORM\Column(name="raised", type="integer", nullable=false)
     */
    private $raised;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255)
     */
    private $etat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="complt", type="integer", nullable=false)
     */
    private $complt;

    /**
     * Cause constructor.
     * @param int $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */

    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * @return string
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @param string $img
     */
    public function setImg($img)
    {
        $this->img = $img;
    }

    /**
     * @return string
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
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getGoals()
    {
        return $this->goals;
    }

    /**
     * @param int $goals
     */
    public function setGoals($goals)
    {
        $this->goals = $goals;
    }

    /**
     * @return int
     */
    public function getRaised()
    {
        return $this->raised;
    }

    /**
     * @param int $raised
     */
    public function setRaised($raised)
    {
        $this->raised = $raised;
    }

    /**
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param string $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getComplt()
    {
        return $this->complt;
    }

    /**
     * @param int $complt
     */
    public function setComplt($complt)
    {
        $this->complt = $complt;
    }



}

