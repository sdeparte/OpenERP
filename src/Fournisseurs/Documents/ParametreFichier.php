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
    private $description;

    /**
     * @var string
     *
     * @ODM\Field
     * @Assert\NotBlank
     */
    private $fichierUrl;

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
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return ParametreFichier
     */
    public function setDescription(string $description): ParametreFichier
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
     * @return ParametreFichier
     */
    public function setFichierUrl(string $fichierUrl): ParametreFichier
    {
        $this->fichierUrl = $fichierUrl;
        return $this;
    }
}