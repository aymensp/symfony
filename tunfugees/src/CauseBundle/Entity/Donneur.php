<?php

namespace CauseBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Donneru
 *
 * @ORM\Table(name="donneur")
 * @ORM\Entity(repositoryClass="CauseBundle\Repository\CauseRepository")
 */
class Donneur
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
     * @var integer
     *
     * @ORM\Column(name="cin", type="integer", nullable=false)
     */
    private $cin;
    /**
     * @var integer
     *
     * @ORM\Column(name="don", type="integer", nullable=false)
     */
    private $don;
    /**
     * @var integer
     *
     * @ORM\Column(name="numcarte", type="integer", nullable=false)
     */
    private $numcarte;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255)
     */
    private $mail;

    /**
     * Donneur constructor.
     * @param int $id
     * @param int $cin
     * @param int $don
     * @param int $numcarte
     * @param string $nom
     * @param string $prenom
     * @param string $mail
     */
    public function __construct($id, $cin, $don, $numcarte, $nom, $prenom, $mail)
    {
        $this->id = $id;
        $this->cin = $cin;
        $this->don = $don;
        $this->numcarte = $numcarte;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->mail = $mail;
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
     * @return int
     */
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * @param int $cin
     */
    public function setCin($cin)
    {
        $this->cin = $cin;
    }

    /**
     * @return int
     */
    public function getDon()
    {
        return $this->don;
    }

    /**
     * @param int $don
     */
    public function setDon($don)
    {
        $this->don = $don;
    }

    /**
     * @return int
     */
    public function getNumcarte()
    {
        return $this->numcarte;
    }

    /**
     * @param int $numcarte
     */
    public function setNumcarte($numcarte)
    {
        $this->numcarte = $numcarte;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }
}