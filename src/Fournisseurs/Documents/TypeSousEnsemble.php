<?php

namespace App\Fournisseurs\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ModelBundle\Validator\Unique;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource
 *
 * @ODM\Document
 * @Unique(self::class, fields="lettre", message="Un type de sous ensemble existe déjà avec cette lettre.")
 */
class TypeSousEnsemble
{
    /**
     * @ODM\Id(strategy="INCREMENT", type="int")
     *
     * @Groups({"sousEnsemble:read"})
     */
    private int $id;

    /**
     * @ODM\Field
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 1,
     *      max = 1,
     *      minMessage = "Veuillez saisire qu'une seul lettre",
     *      maxMessage = "Veuillez saisire qu'une seul lettre"
     * )
     *
     * @Groups({"article:read", "sousEnsemble:read"})
     */
    private string $lettre;

    /**
     * @ODM\Field
     * @Assert\NotBlank
     *
     * @Groups({"article:read", "sousEnsemble:read"})
     */
    private string $nom;

    /**
     * @ODM\Field(type="boolean")
     *
     * @Groups({"article:read", "sousEnsemble:read"})
     */
    private bool $isAssemblage = false;

    public function getId(): int
    {
        return $this->id;
    }

    public function setLettre(string $lettre): TypeSousEnsemble
    {
        $this->lettre = strtoupper($lettre);

        return $this;
    }

    public function getLettre(): string
    {
        return $this->lettre;
    }

    public function setNom($nom): TypeSousEnsemble
    {
        $this->nom = ucfirst($nom);

        return $this;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function isAssemblage(): bool
    {
        return $this->isAssemblage;
    }

    public function setIsAssemblage(bool $isAssemblage): TypeSousEnsemble
    {
        $this->isAssemblage = $isAssemblage;

        return $this;
    }
}