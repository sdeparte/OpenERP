<?php

namespace App\Fournisseurs\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ModelBundle\Validator\Iri;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ODM\Id(strategy="INCREMENT", type="int")
     *
     * @Groups({"article:read", "version:read", "referenceFournisseur:read"})
     */
    private int $id;

    /**
     * @ODM\ReferenceOne(targetDocument=Fournisseur::class)
     *
     * @Groups({"article:read", "version:read", "referenceFournisseur:read", "referenceFournisseur:write"})
     */
    private Fournisseur $fournisseurIri;

    /**
     * @ODM\ReferenceOne(targetDocument=Version::class)
     *
     * @Groups({"article:read", "version:read", "referenceFournisseur:read", "referenceFournisseur:write"})
     */
    private Version $versionIri;

    /**
     * @ODM\Field
     * @Assert\NotBlank
     *
     * @Groups({"article:read", "version:read", "referenceFournisseur:read", "referenceFournisseur:write"})
     */
    private string $reference;

    /**
     * @ODM\EmbedMany(targetDocument=Tarif::class)
     *
     * @Groups({"article:read", "version:read", "referenceFournisseur:read"})
     */
    private Collection $tarifIris;

    public function __construct()
    {
        $this->tarifIris = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFournisseurIri(): Fournisseur
    {
        return $this->fournisseurIri;
    }

    public function setFournisseurIri(Fournisseur $fournisseurIri): ReferenceFournisseur
    {
        $this->fournisseurIri = $fournisseurIri;

        return $this;
    }

    public function getVersionIri(): Version
    {
        return $this->versionIri;
    }

    public function setVersionIri(Version $versionIri): ReferenceFournisseur
    {
        $this->versionIri = $versionIri;

        return $this;
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function setReference(string $reference): ReferenceFournisseur
    {
        $this->reference = $reference;

        return $this;
    }

    public function getTarifIris(): Collection
    {
        return $this->tarifIris;
    }

    public function addTarifIri(Tarif $tarifIri): ReferenceFournisseur
    {
        if (!$this->tarifIris->contains($tarifIri)) {
            $this->tarifIris->add($tarifIri);
        }

        return $this;
    }

    public function removeTarifIri(Tarif $tarifIri): ReferenceFournisseur
    {
        if ($this->tarifIris->contains($tarifIri)) {
            $this->tarifIris->removeElement($tarifIri);
        }

        return $this;
    }
}