<?php

namespace App\Employes\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource
 *
 * @ODM\Document
 */
class Employe
{
    /**
     * @ODM\Id(strategy="INCREMENT", type="int")
     */
    private int $id;

    /**
     * @ODM\Field
     * @Assert\NotBlank
     */
    private string $nom;

    /**
     * @ODM\Field
     * @Assert\NotBlank
     */
    private string $prenom;

    /**
     * @ODM\Field
     * @Assert\NotBlank
     */
    private string $initiales;

    /**
     * @ODM\Field
     * @Assert\NotBlank
     */
    private string $sexe;

    /**
     * @ODM\Field(type="int")
     * @Assert\NotBlank
     */
    private int $matricule;

    /***
     * @ODM\Field(type="date")
     * @Assert\NotBlank
     */
    private \DateTime $dateDebMutu;

    /**
     * @ODM\Field(type="float")
     * @Assert\NotBlank
     */
    private float $nbCPayes = 0;

    /**
     * @ODM\Field(type="float")
     * @Assert\NotBlank
     */
    private float $nbRTT = 0;

    /**
     * @ODM\Field(type="float")
     * @Assert\NotBlank
     */
    private float $nbRecup = 0;

    /**
     * @ODM\Field(type="boolean")
     */
    private bool $isDRH = false;

    public function getId(): int
    {
        return $this->id;
    }

    public function setNom(string $nom): Employe
    {
        $this->nom = strtoupper($nom);

        return $this;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setPrenom(string $prenom): Employe
    {
        $this->prenom = ucfirst($prenom);

        return $this;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setInitiales(string $initiales): Employe
    {
        $this->initiales = strtoupper($initiales);

        return $this;
    }

    public function getInitiales(): string
    {
        return $this->initiales;
    }

    public function getSexe(): string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): Employe
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getMatricule(): int
    {
        return $this->matricule;
    }

    public function setMatricule(int $matricule): Employe
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getDateDebMutu(): \DateTime
    {
        return $this->dateDebMutu;
    }

    public function setDateDebMutu(\DateTime $dateDebMutu): Employe
    {
        $this->dateDebMutu = $dateDebMutu;

        return $this;
    }

    public function getNbCPayes(): float
    {
        return $this->nbCPayes;
    }

    public function setNbCPayes(float $nbCPayes): Employe
    {
        $this->nbCPayes = $nbCPayes;

        return $this;
    }

    public function getNbRTT(): float
    {
        return $this->nbRTT;
    }

    public function setNbRTT(float $nbRTT): Employe
    {
        $this->nbRTT = $nbRTT;

        return $this;
    }

    public function getNbRecup(): float
    {
        return $this->nbRecup;
    }

    public function setNbRecup(float $nbRecup): Employe
    {
        $this->nbRecup = $nbRecup;

        return $this;
    }

    public function isDRH(): bool
    {
        return $this->isDRH;
    }

    public function setIsDRH(bool $isDRH): Employe
    {
        $this->isDRH = $isDRH;

        return $this;
    }
}