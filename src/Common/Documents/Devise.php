<?php

namespace App\Common\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ModelBundle\Validator\Iri;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Devise
 *
 * @ApiResource
 *
 * @ODM\Document
 */
class Devise
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
    private $abreviation;

    /**
     * @var string
     *
     * @ODM\Field
     * @Assert\NotBlank
     */
    private $symbole;

    /**
     * Get id
     *
     * @return int
     */
    public function getId(): int
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
    public function setNom(string $nom): Devise
    {
        $this->nom = ucfirst($nom);

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
     * @param string $abreviation
     *
     * @return Devise
     */
    public function setAbreviation(string $abreviation): Devise
    {
        $this->abreviation = strtoupper($abreviation);

        return $this;
    }

    /**
     * @return string
     */
    public function getAbreviation(): string
    {
        return $this->abreviation;
    }

    /**
     * @param string $symbole
     *
     * @return Devise
     */
    public function setSymbole(string $symbole): Devise
    {
        $this->symbole = $symbole;

        return $this;
    }

    /**
     * @return string
     */
    public function getSymbole(): string
    {
        return $this->symbole;
    }

    /**
     * Get display name
     *
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->symbole.' - '.$this->nom;
    }
}