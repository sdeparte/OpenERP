<?php

namespace App\Common\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ModelBundle\Validator\Iri;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"adresse:read"}},
 *     denormalizationContext={"groups"={"adresse:write"}}
 * )
 *
 * @ODM\Document
 */
class Adresse
{
    /**
     * @ODM\Id(strategy="INCREMENT", type="int")
     *
     * @Groups({"adresse:read"})
     */
    private int $id;

    /**
     * @ODM\Field
     * @Assert\NotBlank
     *
     * @Groups({"adresse:read", "adresse:write"})
     */
    private string $adresse;

    /**
     * @ODM\Field
     *
     * @Groups({"adresse:read", "adresse:write"})
     */
    private ?string $adresseSupplement = null;

    /**
     * @ODM\Field
     * @Assert\NotBlank
     *
     * @Groups({"adresse:read", "adresse:write"})
     */
    private string $codePostal;

    /**
     * @ODM\Field
     * @Assert\NotBlank
     *
     * @Groups({"adresse:read", "adresse:write"})
     */
    private string $ville;

    /**
     * @var string|null
     *
     * @ODM\Field
     *
     * @Groups({"adresse:read", "adresse:write"})
     */
    private ?string $cedex = null;

    /**
     * @ODM\ReferenceOne(targetDocument=Pays::class)
     *
     * @Groups({"adresse:read", "adresse:write"})
     */
    private Pays $paysIri;

    public function getId(): int
    {
        return $this->id;
    }

    public function getAdresse(): string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): Adresse
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getAdresseSupplement(): ?string
    {
        return $this->adresseSupplement;
    }

    public function setAdresseSupplement(?string $adresseSupplement): Adresse
    {
        $this->adresseSupplement = $adresseSupplement;

        return $this;
    }

    public function getCodePostal(): string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): Adresse
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getVille(): string
    {
        return $this->ville;
    }

    public function setVille(string $ville): Adresse
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCedex(): ?string
    {
        return $this->cedex;
    }

    public function setCedex(?string $cedex): Adresse
    {
        $this->cedex = $cedex;

        return $this;
    }

    public function getPaysIri(): Pays
    {
        return $this->paysIri;
    }

    public function setPaysIri(Pays $paysIri): Adresse
    {
        $this->paysIri = $paysIri;

        return $this;
    }
}