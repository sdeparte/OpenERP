<?php

namespace App\Common\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ModelBundle\Validator\Iri;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Contact
 *
 * @ApiResource
 *
 * @ODM\Document
 */
class Contact
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
     * @var string|null
     *
     * @ODM\Field
     */
    private $mail = null;

    /**
     * @var string|null
     *
     * @ODM\Field
     */
    private $telephone = null;

    /**
     * @var string|null
     *
     * @ODM\Field
     */
    private $service = null;

    /**
     * @var string
     *
     * @ODM\Field
     * @Iri({"Client", "Fournisseur"})
     */
    private $fromIri;

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
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     *
     * @return Contact
     */
    public function setNom(string $nom): Contact
    {
        $this->nom = $nom;

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
     * @param string $prenom
     *
     * @return Contact
     */
    public function setPrenom(string $prenom): Contact
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMail(): ?string
    {
        return $this->mail;
    }

    /**
     * @param string|null $mail
     *
     * @return Contact
     */
    public function setMail(?string $mail): Contact
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    /**
     * @param string|null $telephone
     *
     * @return Contact
     */
    public function setTelephone(?string $telephone): Contact
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getService(): ?string
    {
        return $this->service;
    }

    /**
     * @param string|null $service
     *
     * @return Contact
     */
    public function setService(?string $service): Contact
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @return string
     */
    public function getFromIri(): string
    {
        return $this->fromIri;
    }

    /**
     * @param string $fromIri
     *
     * @return Contact
     */
    public function setFromIri(string $fromIri): Contact
    {
        $this->fromIri = $fromIri;

        return $this;
    }
}