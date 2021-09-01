<?php

namespace App\Common\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ModelBundle\Validator\Unique;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Pays
 *
 * @ApiResource
 *
 * @ODM\Document
 * @Unique(self::class, fields={"nom"}, message="Un pays existe déjà avec ce nom.")
 */
class Pays
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
     * Get id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     *
     * @return Pays
     */
    public function setNom(string $nom): Pays
    {
        $this->nom = $nom;

        return $this;
    }
}