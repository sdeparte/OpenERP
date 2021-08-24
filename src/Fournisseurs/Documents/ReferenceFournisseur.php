<?php

namespace App\Fournisseurs\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ModelBundle\Validator\Iri;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ReferenceFournisseur
 *
 * @ApiResource
 *
 * @ODM\Document
 */
class ReferenceFournisseur
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
     * @Iri("Fournisseurs")
     */
    private $fournisseurIri;

    /**
     * @var string
     *
     * @ODM\Field
     * @Iri("Fournisseurs")
     */
    private $articleIri;

    /**
     * @var string
     *
     * @ODM\Field
     * @Assert\NotBlank
     */
    private $reference;

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
    public function getArticleIri(): string
    {
        return $this->articleIri;
    }

    /**
     * @param string $articleIri
     *
     * @return ReferenceFournisseur
     */
    public function setArticleIri(string $articleIri): ReferenceFournisseur
    {
        $this->articleIri = $articleIri;

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
}