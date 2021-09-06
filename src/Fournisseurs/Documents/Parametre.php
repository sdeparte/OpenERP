<?php

namespace App\Fournisseurs\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ModelBundle\Validator\Iri;
use App\ModelBundle\Validator\Unique;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

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
     * @ODM\Id(strategy="INCREMENT", type="int")
     *
     * @Groups({"article:read", "version:read"})
     */
    private int $id;

    /**
     * @ODM\ReferenceOne(targetDocument=TypeParametre::class)
     *
     * @Groups({"article:read", "version:read"})
     */
    protected TypeParametre $typeIri;

    /**
     * @ODM\Field
     * @Assert\NotBlank
     *
     * @Groups({"article:read", "version:read"})
     */
    protected string $nom;

    /**
     * @ODM\ReferenceOne(targetDocument=Version::class)
     *
     * @Groups({"article:read", "version:read"})
     */
    protected Version $versionIri;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTypeIri(): TypeParametre
    {
        return $this->typeIri;
    }

    public function setTypeIri(TypeParametre $typeIri): Parametre
    {
        $this->typeIri = $typeIri;

        return $this;
    }

    public function setNom($nom): Parametre
    {
        $this->nom = ucfirst($nom);

        return $this;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getVersionIri(): Version
    {
        return $this->versionIri;
    }

    public function setVersionIri(Version $versionIri): Parametre
    {
        $this->versionIri = $versionIri;

        return $this;
    }
}