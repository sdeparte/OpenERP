<?php

namespace App\Fournisseurs\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ModelBundle\Validator\Iri;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @var int
     *
     * @ODM\Id(strategy="INCREMENT", type="int")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ODM\Field
     */
    private $devis = null;

    /**
     * @var float
     *
     * @ODM\Field(type="float")
     * @Assert\Type(
     *     type="float",
     *     message="{{ value }} n'est pas une quantité valide."
     * )
     */
    private $quantite;

    /**
     * @var float
     *
     * @ODM\Field(type="float")
     * @Assert\Type(
     *     type="float",
     *     message="{{ value }} n'est pas un prix unitaire valide."
     * )
     */
    private $prixUnitHT;

    /**
     * @var string
     *
     * @ODM\Field
     * @Iri("Common")
     */
    private $deviseIri;

    /**
     * @var string
     *
     * @ODM\Field
     * @Iri("Fournisseurs")
     */
    private $referenceFournisseurIri;

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
}