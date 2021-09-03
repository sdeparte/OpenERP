<?php

namespace App\Fournisseurs\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ModelBundle\Validator\Iri;
use App\ModelBundle\Validator\Unique;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Parametre
 *
 * @ApiResource
 *
 * @ODM\Document
 * @Unique(self::class, fields={"typeIri", "nom", "versionIri"}, message="Ce parametre existe déjà.")
 */
class Parametre
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
     * @Assert\NotBlank
     */
    protected $typeIri;

    /**
     * @var string
     *
     * @ODM\Field
     * @Assert\NotBlank
     */
    protected $nom;

    /**
     * @var string
     *
     * @ODM\Field
     * @Iri("Fournisseurs")
     */
    protected $versionIri;

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
    public function getTypeIri(): string
    {
        return $this->typeIri;
    }

    /**
     * @param string $typeIri
     *
     * @return Parametre
     */
    public function setTypeIri(string $typeIri): Parametre
    {
        $this->typeIri = $typeIri;

        return $this;
    }

    /**
     * @param string $nom
     *
     * @return Parametre
     */
    public function setNom($nom): Parametre
    {
        $this->nom = ucfirst($nom);

        return $this;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
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
     * @return Parametre
     */
    public function setVersionIri(string $versionIri): Parametre
    {
        $this->versionIri = $versionIri;

        return $this;
    }
}