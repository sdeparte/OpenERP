<?php

namespace App\Fournisseurs\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ModelBundle\Validator\Iri;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * ParametreFichier
 *
 * @ApiResource
 *
 * @ODM\Document
 */
class ParametreFichier extends Parametre
{
    /**
     * @ODM\Id(strategy="INCREMENT", type="int")
     *
     * @Groups({"article:read", "version:read"})
     */
    private int $id;

    /**
     * @ODM\Field
     * @Assert\NotBlank
     *
     * @Groups({"article:read", "version:read"})
     */
    private string $description;

    /**
     * @ODM\Field
     * @Assert\NotBlank
     *
     * @Groups({"article:read", "version:read"})
     */
    private string $fichierUrl;

    public function getId(): int
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): ParametreFichier
    {
        $this->description = $description;
        return $this;
    }

    public function getFichierUrl(): string
    {
        return $this->fichierUrl;
    }

    public function setFichierUrl(string $fichierUrl): ParametreFichier
    {
        $this->fichierUrl = $fichierUrl;
        return $this;
    }
}