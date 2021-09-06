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
 * Tarif
 *
 * @ApiResource
 *
 * @ODM\Document
 */
class Tarif
{
    /**
     * @ODM\Id(strategy="INCREMENT", type="int")
     */
    private int $id;

    /**
     * @ODM\Field
     *
     * @Groups({"article:read", "version:read", "tarif:read", "tarif:write"})
     */
    private ?string $devis = null;

    /**
     * @ODM\Field(type="float")
     * @Assert\Type(
     *     type="float",
     *     message="{{ value }} n'est pas une quantité valide."
     * )
     *
     * @Groups({"article:read", "version:read", "tarif:read", "tarif:write"})
     */
    private float $quantite;

    /**
     * @ODM\Field(type="float")
     * @Assert\Type(
     *     type="float",
     *     message="{{ value }} n'est pas un prix unitaire valide."
     * )
     *
     * @Groups({"article:read", "version:read", "tarif:read", "tarif:write"})
     */
    private float $prixUnitHT;

    /**
     * @ODM\Field
     * @Iri({"Devise"})
     *
     * @Groups({"article:read", "version:read", "tarif:read", "tarif:write"})
     */
    private string $deviseIri;

    /**
     * @ODM\ReferenceOne(targetDocument=ReferenceFournisseur::class)
     *
     * @Groups({"article:read", "version:read", "tarif:read", "tarif:write"})
     */
    private ReferenceFournisseur $referenceFournisseurIri;

    /**
     * @ODM\ReferenceOne(targetDocument=Parametre::class)
     *
     * @Groups({"article:read", "version:read", "tarif:read"})
     */
    private Collection $parametreIris;

    public function __construct()
    {
        $this->parametreIris = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getDevis(): ?string
    {
        return $this->devis;
    }

    /**
     * @param string|null $devis
     *
     * @return Tarif
     */
    public function setDevis(?string $devis): Tarif
    {
        $this->devis = $devis;

        return $this;
    }

    /**
     * @return float
     */
    public function getQuantite(): float
    {
        return $this->quantite;
    }

    /**
     * @param float $quantite
     *
     * @return Tarif
     */
    public function setQuantite(float $quantite): Tarif
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrixUnitHT(): float
    {
        return $this->prixUnitHT;
    }

    /**
     * @param float $prixUnitHT
     *
     * @return Tarif
     */
    public function setPrixUnitHT(float $prixUnitHT): Tarif
    {
        $this->prixUnitHT = $prixUnitHT;

        return $this;
    }

    /**
     * @return string
     */
    public function getDeviseIri(): string
    {
        return $this->deviseIri;
    }

    /**
     * @param string $deviseIri
     *
     * @return Tarif
     */
    public function setDeviseIri(string $deviseIri): Tarif
    {
        $this->deviseIri = $deviseIri;

        return $this;
    }

    /**
     * @return string
     */
    public function getReferenceFournisseurIri(): string
    {
        return $this->referenceFournisseurIri;
    }

    /**
     * @param string $referenceFournisseurIri
     *
     * @return Tarif
     */
    public function setReferenceFournisseurIri(string $referenceFournisseurIri): Tarif
    {
        $this->referenceFournisseurIri = $referenceFournisseurIri;

        return $this;
    }

    public function getParametreIris(): Collection
    {
        return $this->parametreIris;
    }

    public function addParametreIri(Parametre $parametreIri): Tarif
    {
        if (!$this->parametreIris->contains($parametreIri)) {
            $this->parametreIris->add($parametreIri);
        }

        return $this;
    }

    public function removeParametreIri(Parametre $parametreIri): Tarif
    {
        if (!$this->parametreIris->contains($parametreIri)) {
            $this->parametreIris->add($parametreIri);
        }

        return $this;
    }
}