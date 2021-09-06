<?php

namespace App\Common\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ModelBundle\Validator\Iri;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource
 *
 * @ODM\Document
 */
class Contact
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
     * @Assert\Email
     */
    private ?string $mail = null;

    /**
     * @ODM\Field
     * @Assert\Regex("/^\+33\(0\)[0-9]*$/", message="Ce champ doit être un numéro de téléphone valide")
     */
    private ?string $telephone = null;

    /**
     * @ODM\Field
     */
    private ?string $service = null;

    /**
     * @ODM\Field
     * @Iri({"Client", "Fournisseur", "Employe"})
     */
    private string $fromIri;

    public function getId(): int
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): Contact
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): Contact
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): Contact
    {
        $this->mail = $mail;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): Contact
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getService(): ?string
    {
        return $this->service;
    }

    public function setService(?string $service): Contact
    {
        $this->service = $service;

        return $this;
    }

    public function getFromIri(): string
    {
        return $this->fromIri;
    }

    public function setFromIri(string $fromIri): Contact
    {
        $this->fromIri = $fromIri;

        return $this;
    }
}