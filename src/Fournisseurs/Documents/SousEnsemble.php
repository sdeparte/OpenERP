<?php

namespace App\Fournisseurs\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ModelBundle\Validator\Iri;
use App\ModelBundle\Validator\Unique;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"sousEnsemble:read"}},
 *     denormalizationContext={"groups"={"sousEnsemble:write"}}
 * )
 *
 * @ODM\Document
 * @Unique(self::class, fields={"typeIri", "numero"}, message="Un sous ensemble existe déjà avec ces type / numéro.")
 */
class SousEnsemble
{
    /**
     * @ODM\Id(strategy="INCREMENT", type="int")
     *
     * @Groups({"article:read", "sousEnsemble:read"})
     */
    private int $id;

    /**
     * @ODM\ReferenceOne(targetDocument=TypeSousEnsemble::class)
     *
     * @Groups({"article:read", "sousEnsemble:read", "sousEnsemble:write"})
     */
    private TypeSousEnsemble $typeIri;

    /**
     * @ODM\Field
     * @Assert\NotBlank
     * @Assert\Regex("/^\d+$/", message="Ce champ ne peut être composé que de chiffres")
     * @Assert\NotEqualTo("00", message="Ce champ ne peut être égale à '00'")
     * @Assert\Length(
     *      min = 2,
     *      max = 2,
     *      minMessage = "Veuillez saisire un nombre à 2 chiffres",
     *      maxMessage = "Veuillez saisire un nombre à 2 chiffres"
     * )
     *
     * @Groups({"article:read", "sousEnsemble:read", "sousEnsemble:write"})
     */
    private string $numero = '01';

    /**
     * @ODM\Field
     * @Assert\NotBlank
     *
     * @Groups({"article:read", "sousEnsemble:read", "sousEnsemble:write"})
     */
    private string $nom;

    public function getId(): int
    {
        return $this->id;
    }

    public function setTypeIri(TypeSousEnsemble $typeIri): SousEnsemble
    {
        $this->typeIri = $typeIri;

        return $this;
    }

    public function getTypeIri(): TypeSousEnsemble
    {
        return $this->typeIri;
    }

    public function setNumero(string $numero): SousEnsemble
    {
        $this->numero = $numero;

        return $this;
    }

    public function getNumero(): string
    {
        return $this->numero;
    }

    public function setNom($nom): SousEnsemble
    {
        $this->nom = ucfirst($nom);

        return $this;
    }

    public function getNom(): string
    {
        return $this->nom;
    }
}