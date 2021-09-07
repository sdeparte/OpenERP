<?php

namespace App\Comptabilite\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ModelBundle\Validator\Unique;
use App\ModelBundle\Validator\ValidCompteComptable;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource
 *
 * @ODM\Document
 * @Unique(self::class, fields={"numero"}, message="Un compte comptable existe déjà avec ce nuémro comptable.")
 */
class CompteComptable
{
    /**
     * @ODM\Id(strategy="INCREMENT", type="int")
     */
    private int $id;

    /**
     * @ODM\Field
     * @Assert\NotBlank
     * @Assert\Type(
     *     type="digit",
     *     message="{{ value }} n'est pas un numéro de compte valide."
     * )
     * @Assert\Length(
     *      min = 8,
     *      max = 8,
     *      exactMessage = "Un numéro de compte comptable doit être composé de {{ limit }} caractères"
     * )
     * @ValidCompteComptable
     */
    private string $numero;

    /**
     * @ODM\Field
     * @Assert\NotBlank
     */
    private string $nom;

    public function getId(): int
    {
        return $this->id;
    }

    public function getNumero(): string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): CompteComptable
    {
        $this->numero = $numero;

        return $this;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): CompteComptable
    {
        $this->nom = $nom;

        return $this;
    }
}