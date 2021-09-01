<?php

namespace App\Fournisseurs\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ModelBundle\Validator\Iri;
use App\ModelBundle\Validator\Unique;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SousEnsemble
 *
 * @ApiResource
 *
 * @ODM\Document
 * @Unique(self::class, fields={"type", "numero"}, message="Un sous ensemble existe déjà avec ces type / numéro.")
 */
class SousEnsemble
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
     * @Iri("Fournisseurs")
     * @Assert\NotBlank
     */
    private $typeIri;

    /**
     * @var string
     *
     * @ODM\Field
     * @Assert\NotBlank
     */
    private $numero;

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
     * @param string $typeIri
     *
     * @return SousEnsemble
     */
    public function setTypeIri(string $typeIri): SousEnsemble
    {
        $this->typeIri = $typeIri;

        return $this;
    }

    /**
     * @return string
     */
    public function getTypeIri(): string
    {
        return $this->typeIri;
    }

    /**
     * @param string $numero
     *
     * @return SousEnsemble
     */
    public function setNumero(string $numero): SousEnsemble
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * @return string
     */
    public function getNumero(): string
    {
        return $this->numero;
    }

    /**
     * @param string $nom
     *
     * @return SousEnsemble
     */
    public function setNom($nom): SousEnsemble
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