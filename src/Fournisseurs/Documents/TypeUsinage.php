<?php

namespace App\Fournisseurs\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ModelBundle\Validator\Unique;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TypeUsinage
 *
 * @ApiResource
 *
 * @ODM\Document
 * @Unique(self::class, fields={"nom"}, message="Un type d'usinage existe déjà avec ce nom.")
 */
class TypeUsinage
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
    private $nom;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $nom
     *
     * @return TypeUsinage
     */
    public function setNom($nom): TypeUsinage
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
}