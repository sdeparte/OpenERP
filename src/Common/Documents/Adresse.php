<?php

namespace App\Common\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ModelBundle\Validator\Iri;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Adresse
 *
 * @ApiResource
 *
 * @ODM\Document
 */
class Adresse
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
    private $adresse;

    /**
     * @var string|null
     *
     * @ODM\Field
     */
    private $adresseSupplement = null;

    /**
     * @var string
     *
     * @ODM\Field
     * @Assert\NotBlank
     */
    private $codePostal;

    /**
     * @var string
     *
     * @ODM\Field
     * @Assert\NotBlank
     */
    private $ville;

    /**
     * @var string|null
     *
     * @ODM\Field
     */
    private $cedex = null;

    /**
     * @var string
     *
     * @ODM\Field
     * @Iri("Common")
     */
    private $paysIri;

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
     * @return string
     */
    public function getAdresse(): string
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     *
     * @return Adresse
     */
    public function setAdresse(string $adresse): Adresse
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAdresseSupplement(): ?string
    {
        return $this->adresseSupplement;
    }

    /**
     * @param string|null $adresseSupplement
     *
     * @return Adresse
     */
    public function setAdresseSupplement(?string $adresseSupplement): Adresse
    {
        $this->adresseSupplement = $adresseSupplement;

        return $this;
    }

    /**
     * @return string
     */
    public function getCodePostal(): string
    {
        return $this->codePostal;
    }

    /**
     * @param string $codePostal
     *
     * @return Adresse
     */
    public function setCodePostal(string $codePostal): Adresse
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * @return string
     */
    public function getVille(): string
    {
        return $this->ville;
    }

    /**
     * @param string $ville
     *
     * @return Adresse
     */
    public function setVille(string $ville): Adresse
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCedex(): ?string
    {
        return $this->cedex;
    }

    /**
     * @param string|null $cedex
     *
     * @return Adresse
     */
    public function setCedex(?string $cedex): Adresse
    {
        $this->cedex = $cedex;

        return $this;
    }

    /**
     * @return string
     */
    public function getPaysIri(): string
    {
        return $this->paysIri;
    }

    /**
     * @param string $paysIri
     *
     * @return Adresse
     */
    public function setPaysIri(string $paysIri): Adresse
    {
        $this->paysIri = $paysIri;

        return $this;
    }
}