<?php

namespace App\Fournisseurs\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ModelBundle\Validator\Unique;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TypeSousEnsemble
 *
 * @ApiResource
 *
 * @ODM\Document
 * @Unique(self::class, fields="lettre", message="Un type de sous ensemble existe déjà avec cette lettre.")
 */
class TypeSousEnsemble
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
     * @Assert\Length(
     *      min = 1,
     *      max = 1,
     *      minMessage = "Veuillez saisire qu'une seul lettre",
     *      maxMessage = "Veuillez saisire qu'une seul lettre"
     * )
     */
    private $lettre;

    /**
     * @var string
     *
     * @ODM\Field
     * @Assert\NotBlank
     */
    private $nom;

    /**
     * @var bool
     *
     * @ODM\Field(type="boolean")
     */
    private $isAssemblage = false;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $lettre
     *
     * @return TypeSousEnsemble
     */
    public function setLettre(string $lettre): TypeSousEnsemble
    {
        $this->lettre = strtoupper($lettre);

        return $this;
    }

    /**
     * @return string
     */
    public function getLettre(): string
    {
        return $this->lettre;
    }

    /**
     * @param string $nom
     *
     * @return TypeSousEnsemble
     */
    public function setNom($nom): TypeSousEnsemble
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
     * @return bool
     */
    public function isAssemblage(): bool
    {
        return $this->isAssemblage;
    }

    /**
     * @param bool $isAssemblage
     *
     * @return TypeSousEnsemble
     */
    public function setIsAssemblage(bool $isAssemblage): TypeSousEnsemble
    {
        $this->isAssemblage = $isAssemblage;

        return $this;
    }
}