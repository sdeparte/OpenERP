<?php

namespace App\Employes\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Employe
 *
 * @ApiResource
 *
 * @ODM\Document
 */
class Employe
{
    /**
     * @var int
     *
     * @ODM\Id(strategy="INCREMENT", type="int")
     */
    private $id;

    /**
     * @var string
     *
     * @ODM\Field
     * @Assert\NotBlank
     */
    private $nom;

    /**
     * @var string
     *
     * @ODM\Field
     * @Assert\NotBlank
     */
    private $prenom;

    /**
     * @var string
     *
     * @ODM\Field
     * @Assert\NotBlank
     */
    private $initiales;

    /**
     * @var string
     *
     * @ODM\Field
     * @Assert\NotBlank
     */
    private $sexe;

    /**
     * @var int
     *
     * @ODM\Field(type="int")
     * @Assert\NotBlank
     */
    private $matricule;

    /**
     * @var \DateTime
     *
     * @ODM\Field(type="date")
     * @Assert\NotBlank
     */
    private $dateDebMutu;

    /**
     * @var float
     *
     * @ODM\Field(type="float")
     * @Assert\NotBlank
     */
    private $nbCPayes = 0;

    /**
     * @var float
     *
     * @ODM\Field(type="float")
     * @Assert\NotBlank
     */
    private $nbRTT = 0;

    /**
     * @var float
     *
     * @ODM\Field(type="float")
     * @Assert\NotBlank
     */
    private $nbRecup = 0;

    /**
     * @var bool
     *
     * @ODM\Field(type="boolean")
     */
    private $isDRH = false;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $nom
     *
     * @return Employe
     */
    public function setNom(string $nom): Employe
    {
        $this->nom = strtoupper($nom);

        return $this;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     *
     * @return Employe
     */
    public function setPrenom(string $prenom): Employe
    {
        $this->prenom = ucfirst($prenom);

        return $this;
    }

    /**
     * @return string
     */
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * @param string $nom
     *
     * @return Employe
     */
    public function setInitiales(string $initiales): Employe
    {
        $this->initiales = strtoupper($initiales);

        return $this;
    }

    /**
     * @return string
     */
    public function getInitiales(): string
    {
        return $this->initiales;
    }

    /**
     * @return string
     */
    public function getSexe(): string
    {
        return $this->sexe;
    }

    /**
     * @param string $sexe
     *
     * @return Employe
     */
    public function setSexe(string $sexe): Employe
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * @return int
     */
    public function getMatricule(): int
    {
        return $this->matricule;
    }

    /**
     * @param int $matricule
     *
     * @return Employe
     */
    public function setMatricule(int $matricule): Employe
    {
        $this->matricule = $matricule;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateDebMutu(): \DateTime
    {
        return $this->dateDebMutu;
    }

    /**
     * @param \DateTime $dateDebMutu
     *
     * @return Employe
     */
    public function setDateDebMutu(\DateTime $dateDebMutu): Employe
    {
        $this->dateDebMutu = $dateDebMutu;

        return $this;
    }

    /**
     * @return float
     */
    public function getNbCPayes(): float
    {
        return $this->nbCPayes;
    }

    /**
     * @param float $nbCPayes
     *
     * @return Employe
     */
    public function setNbCPayes(float $nbCPayes): Employe
    {
        $this->nbCPayes = $nbCPayes;

        return $this;
    }

    /**
     * @return float
     */
    public function getNbRTT(): float
    {
        return $this->nbRTT;
    }

    /**
     * @param float $nbRTT
     *
     * @return Employe
     */
    public function setNbRTT(float $nbRTT): Employe
    {
        $this->nbRTT = $nbRTT;

        return $this;
    }

    /**
     * @return float
     */
    public function getNbRecup(): float
    {
        return $this->nbRecup;
    }

    /**
     * @param float $nbRecup
     *
     * @return Employe
     */
    public function setNbRecup(float $nbRecup): Employe
    {
        $this->nbRecup = $nbRecup;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDRH(): bool
    {
        return $this->isDRH;
    }

    /**
     * @param bool $isDRH
     *
     * @return Employe
     */
    public function setIsDRH(bool $isDRH): Employe
    {
        $this->isDRH = $isDRH;

        return $this;
    }
}