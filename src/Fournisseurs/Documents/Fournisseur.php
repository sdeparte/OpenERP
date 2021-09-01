<?php

namespace App\Fournisseurs\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ModelBundle\Interfaces\ClientFournisseurInterface;
use App\ModelBundle\Validator\Iri;
use App\ModelBundle\Validator\Unique;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Fournisseur
 *
 * @ApiResource
 *
 * @ODM\Document
 * @Unique(self::class, fields={"nom"}, message="Un fourniseur existe déjà avec ce nom.")
 */
class Fournisseur implements ClientFournisseurInterface
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
     * @var string
     *
     * @ODM\Field
     * @Iri("Common")
     */
    private $domaineIri;

    /**
     * @var string
     *
     * @ODM\Field
     * @Assert\Choice{
     *     "A la commande",
     *     "30 jours fin de mois",
     *     "30 jours début de mois",
     *     "30 jours au 15 du mois"
     * }
     */
    private $conditionPaiement;

    /**
     * @var bool
     *
     * @ODM\Field(type="boolean")
     */
    private $valide = false;

    /**
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
     * @return Fournisseur
     */
    public function setNom(string $nom): Fournisseur
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return string
     */
    public function getDomaineIri(): string
    {
        return $this->domaineIri;
    }

    /**
     * @param string $domaineIri
     * @return Fournisseur
     */
    public function setDomaineIri(string $domaineIri): Fournisseur
    {
        $this->domaineIri = $domaineIri;
        return $this;
    }

    /**
     * @return string
     */
    public function getConditionPaiement(): string
    {
        return $this->conditionPaiement;
    }

    /**
     * @param string $conditionPaiement
     * @return Fournisseur
     */
    public function setConditionPaiement(string $conditionPaiement): Fournisseur
    {
        $this->conditionPaiement = $conditionPaiement;
        return $this;
    }

    /**
     * @return bool
     */
    public function isValide(): bool
    {
        return $this->valide;
    }

    /**
     * @param bool $valide
     *
     * @return Article
     */
    public function setValide(bool $valide): Article
    {
        $this->valide = $valide;

        return $this;
    }
}