<?php

namespace App\Common\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ModelBundle\Validator\Unique;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource
 *
 * @ODM\Document
 * @Unique(self::class, fields={"nom"}, message="Un pays existe déjà avec ce nom.")
 */
class Pays
{
    /**
     * @ODM\Id(strategy="INCREMENT", type="int")
     *
     * @Groups({"adresse:read"})
     */
    private int $id;

    /**
     * @ODM\Field
     * @Assert\NotBlank
     *
     * @Groups({"adresse:read"})
     */
    private string $nom;

    public function getId(): int
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): Pays
    {
        $this->nom = $nom;

        return $this;
    }
}