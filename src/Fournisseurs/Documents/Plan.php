<?php

namespace App\Fournisseurs\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ModelBundle\Validator\Iri;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Plan
 *
 * @ApiResource
 *
 * @ODM\Document
 */
class Plan
{
    /**
     * @var int
     *
     * @ODM\Id(strategy="INCREMENT", type="int")
     *
     * @Groups("article:read")
     */
    private $id;

    /**
     * @var string
     *
     * @ODM\Field
     * @Assert\NotBlank
     *
     * @Groups("article:read")
     */
    private $nom;

    /**
     * @var string
     *
     * @ODM\Field
     * @Assert\NotBlank
     *
     * @Groups("article:read")
     */
    private $description;

    /**
     * @var string
     *
     * @ODM\Field
     * @Assert\NotBlank
     *
     * @Groups("article:read")
     */
    private $fichierUrl;

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
     *
     * @Groups("article:read")
     */
    private $indice = 'A';

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
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     *
     * @return Plan
     */
    public function setNom(string $nom): Plan
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Plan
     */
    public function setDescription(string $description): Plan
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getFichierUrl(): string
    {
        return $this->fichierUrl;
    }

    /**
     * @param string $fichierUrl
     *
     * @return Plan
     */
    public function setFichierUrl(string $fichierUrl): Plan
    {
        $this->fichierUrl = $fichierUrl;

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
     * @return Plan
     */
    public function setArticleIri(string $articleIri): Plan
    {
        $this->articleIri = $articleIri;

        return $this;
    }

    /**
     * @return string
     */
    public function getIndice(): string
    {
        return $this->indice;
    }

    /**
     * @param string $indice
     *
     * @return Plan
     */
    public function setIndice(string $indice): Plan
    {
        $this->indice = $indice;

        return $this;
    }
}