<?php

namespace App\Common\Entity;

/**
 * Devise
 *
 * @ORM\Table(name="devise")
 * @ORM\Entity(repositoryClass="SD\CommonBundle\Repository\DeviseRepository")
 */
class Devise
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="abreviation", type="string", length=3)
     */
    private $abreviation;

    /**
     * @var string
     *
     * @ORM\Column(name="symbole", type="string", length=10)
     */
    private $symbole;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Devise
     */
    public function setNom($nom)
    {
        $this->nom = ucfirst($nom);

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set abreviation
     *
     * @param string $abreviation
     *
     * @return Devise
     */
    public function setAbreviation($abreviation)
    {
        $this->abreviation = strtoupper($abreviation);

        return $this;
    }

    /**
     * Get abreviation
     *
     * @return string
     */
    public function getAbreviation()
    {
        return $this->abreviation;
    }

    /**
     * Set symbole
     *
     * @param string $symbole
     *
     * @return Devise
     */
    public function setSymbole($symbole)
    {
        $this->symbole = $symbole;

        return $this;
    }

    /**
     * Get symbole
     *
     * @return string
     */
    public function getSymbole()
    {
        return $this->symbole;
    }

    /**
     * Get display name
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->symbole.' - '.$this->nom;
    }
}