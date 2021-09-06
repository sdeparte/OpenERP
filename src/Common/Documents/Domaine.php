<?php

namespace App\Common\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ModelBundle\Validator\Unique;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource
 *
 * @ODM\Document
 * @Unique(self::class, fields={"nom"}, message="Un domaine existe déjà avec ce nom.")
 */
class Domaine
{
    /**
     * @ODM\Id(strategy="INCREMENT", type="int")
     */
    private int $id;

    /**
     * @ODM\Field
     * @Assert\NotBlank
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

    public function setNom(string $nom): Domaine
    {
        $this->nom = $nom;

        return $this;
    }
}