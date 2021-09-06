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
 * @Unique(self::class, fields={"nom"}, message="Un type de parametre existe déjà avec ce nom.")
 */
class TypeParametre
{
    /**
     * @ODM\Id(strategy="INCREMENT", type="int")
     *
     * @Groups({"article:read"})
     */
    private int $id;

    /**
     * @ODM\Field
     * @Assert\NotBlank
     *
     * @Groups({"article:read"})
     */
    private string $nom;

    public function getId(): int
    {
        return $this->id;
    }

    public function setNom($nom): TypeParametre
    {
        $this->nom = ucfirst($nom);

        return $this;
    }

    public function getNom(): string
    {
        return $this->nom;
    }
}