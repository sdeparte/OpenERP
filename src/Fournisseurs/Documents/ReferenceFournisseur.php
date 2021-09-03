<?php

namespace App\Fournisseurs\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ModelBundle\Validator\Iri;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * ReferenceFournisseur
 *
 * @ApiResource(
 *     normalizationContext={"groups"={"referenceFournisseur:read"}},
 *     denormalizationContext={"groups"={"referenceFournisseur:write"}}
 * )
 *
 * @ODM\Document
 */
class ReferenceFournisseur
{
    /**
     * @var int
     *
     * @ODM\Id(strategy="INCREMENT", type="int")
     *
     * @Groups({"referenceFournisseur:read"})
     */
    private $id;

    /**
     * @var string
     *
     * @ODM\Field
     *
     * @Groups({"referenceFournisseur:read", "referenceFournisseur:write"})
     */
    private $fournisseurIri;

    /**
     * @var string
     *
     * @ODM\Field
     * @Iri("Fournisseurs")
     *
     * @Groups({"referenceFournisseur:read", "referenceFournisseur:write"})
     */
    private $versionIri;

    /**
     * @var string
     *
     * @ODM\Field
     * @Assert\NotBlank
     *
     * @Groups({"referenceFournisseur:read", "referenceFournisseur:write"})
     */
    private $reference;

    /**
     * @var array
     *
     * @ODM\Field(type="collection")
     *
     * @Groups({"referenceFournisseur:read"})
     */
    private $tarifIris = [];

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFournisseurIri(): string
    {
        return $this->fournisseurIri;
    }

    /**
     * @param string $fournisseurIri
     *
     * @return ReferenceFournisseur
     */
    public function setFournisseurIri(string $fournisseurIri): ReferenceFournisseur
    {
        $this->fournisseurIri = $fournisseurIri;

        return $this;
    }

    /**
     * @return string
     */
    public function getVersionIri(): string
    {
        return $this->versionIri;
    }

    /**
     * @param string $versionIri
     *
     * @return ReferenceFournisseur
     */
    public function setVersionIri(string $versionIri): ReferenceFournisseur
    {
        $this->versionIri = $versionIri;

        return $this;
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     *
     * @return ReferenceFournisseur
     */
    public function setReference(string $reference): ReferenceFournisseur
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return array
     */
    public function getTarifIris(): array
    {
        return $this->tarifIris;
    }

    /**
     * @param string $tarifIri
     *
     * @return ReferenceFournisseur
     */
    public function addTarifIri(string $tarifIri): ReferenceFournisseur
    {
        if (!\in_array($tarifIri, $this->tarifIris)) {
            $this->tarifIris[] = $tarifIri;
        }

        return $this;
    }

    /**
     * @param string $tarifIri
     *
     * @return ReferenceFournisseur
     */
    public function removeTarifIri(string $tarifIri): ReferenceFournisseur
    {
        $this->tarifIris = \array_diff($this->tarifIris, [$tarifIri]);

        return $this;
    }
}