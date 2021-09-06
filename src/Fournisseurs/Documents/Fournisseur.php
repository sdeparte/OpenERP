<?php

namespace App\Fournisseurs\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ModelBundle\Interfaces\ClientFournisseurInterface;
use App\ModelBundle\Validator\Iri;
use App\ModelBundle\Validator\Unique;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"fournisseur:read"}},
 *     denormalizationContext={"groups"={"fournisseur:write"}}
 * )
 *
 * @ODM\Document(repositoryClass="App\Fournisseurs\Repositories\FournisseurRepository")
 * @Unique(self::class, fields={"nom"}, message="Un fourniseur existe déjà avec ce nom.")
 */
class Fournisseur implements ClientFournisseurInterface
{
    /**
     * @ODM\Id(strategy="INCREMENT", type="int")
     *
     * @Groups({"fournisseur:read"})
     */
    private int $id;

    /**
     * @ODM\Field
     * @Assert\NotBlank
     *
     * @Groups({"fournisseur:read", "fournisseur:write"})
     */
    private string $nom;

    /**
     * @ODM\Field
     * @Iri({"Adresse"})
     *
     * @Groups({"fournisseur:read", "fournisseur:write"})
     */
    private string $adresseIri;

    /**
     * @ODM\Field
     * @Iri({"Domaine"})
     *
     * @Groups({"fournisseur:read", "fournisseur:write"})
     */
    private string $domaineIri;

    /**
     * @ODM\Field
     * @Assert\Choice({
     *     "A la commande",
     *     "30 jours fin de mois",
     *     "30 jours début de mois",
     *     "30 jours au 15 du mois"
     * })
     *
     * @Groups({"fournisseur:read", "fournisseur:write"})
     */
    private string $conditionPaiement = '30 jours fin de mois';

    /**
     * @ODM\Field(type="collection")
     *
     * @Groups({"fournisseur:read"})
     */
    private array $contactIris = [];

    /**
     * @ODM\Field(type="boolean")
     */
    private bool $valide = false;

    public function getId(): int
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): Fournisseur
    {
        $this->nom = $nom;
        return $this;
    }

    public function getDomaineIri(): string
    {
        return $this->domaineIri;
    }

    public function setDomaineIri(string $domaineIri): Fournisseur
    {
        $this->domaineIri = $domaineIri;
        return $this;
    }

    public function getConditionPaiement(): string
    {
        return $this->conditionPaiement;
    }

    public function setConditionPaiement(string $conditionPaiement): Fournisseur
    {
        $this->conditionPaiement = $conditionPaiement;

        return $this;
    }

    /**
     * @return string
     */
    public function getAdresseIri(): string
    {
        return $this->adresseIri;
    }

    /**
     * @param string $adresseIri
     */
    public function setAdresseIri(string $adresseIri): Fournisseur
    {
        $this->adresseIri = $adresseIri;

        return $this;
    }

    public function getContactIris(): array
    {
        return $this->contactIris;
    }

    public function addContactIri(string $contactIri): Fournisseur
    {
        if (!\in_array($contactIri, $this->contactIris)) {
            $this->contactIris[] = $contactIri;
        }

        return $this;
    }

    public function removeContactIri(string $contactIri): Fournisseur
    {
        $this->contactIris = \array_diff($this->contactIris, [$contactIri]);

        return $this;
    }

    public function isValide(): bool
    {
        return $this->valide;
    }

    public function setValide(bool $valide): Fournisseur
    {
        $this->valide = $valide;

        return $this;
    }
}