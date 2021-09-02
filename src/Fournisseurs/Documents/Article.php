<?php

namespace App\Fournisseurs\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ModelBundle\Validator\Iri;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Article
 *
 * @ApiResource(
 *     normalizationContext={"groups"={"article:read"}},
 *     denormalizationContext={"groups"={"article:write"}},
 *     itemOperations={
 *          "get",
 *          "patch",
 *          "put",
 *          "delete"
 *     },
 * )
 *
 * @ODM\Document(repositoryClass="App\Fournisseurs\Repositories\ArticleRepository")
 */
class Article
{
    /**
     * @var int
     *
     * @ODM\Id(strategy="INCREMENT", type="int")
     *
     * @Groups("article:read")
     */
    private $id;

    /**
     * @var string
     *
     * @ODM\Field
     * @Iri("Fournisseurs")
     *
     * @Groups({"article:read", "article:write"})
     */
    private $sousEnsembleIri;

    /**
     * @var string
     *
     * @ODM\Field
     * @Assert\Length(
     *      min = 6,
     *      max = 6,
     *      minMessage = "Veuillez saisire {{ min }} caractères",
     *      maxMessage = "Veuillez saisire {{ max }} caractères"
     * )
     *
     * @Groups({"article:read"})
     */
    private $numero = "000001";

    /**
     * @var string
     *
     * @ODM\Field
     * @Assert\NotBlank
     *
     * @Groups({"article:read", "article:write"})
     */
    private $decriptionInterne;

    /**
     * @var string|null
     *
     * @ODM\Field
     *
     * @Groups({"article:read", "article:write"})
     */
    private $decriptionExterne = null;

    /**
     * @var bool
     *
     * @ODM\Field(type="boolean")
     *
     * @Groups({"article:read", "article:write"})
     */
    private $valide = false;

    /**
     * @var array
     *
     * @ODM\Field(type="collection")
     *
     * @Groups({"article:read"})
     */
    private $couleurIris = [];

    /**
     * @var array
     *
     * @ODM\Field(type="collection")
     *
     * @Groups({"article:read"})
     */
    private $matiereIris = [];

    /**
     * @var array
     *
     * @ODM\Field(type="collection")
     *
     * @Groups("article:read")
     */
    private $planIris = [];

    /**
     * @var array
     *
     * @ODM\Field(type="collection")
     *
     * @Groups({"article:read"})
     */
    private $tarifIris = [];

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
    public function getSousEnsembleIri(): string
    {
        return $this->sousEnsembleIri;
    }

    /**
     * @param string $sousEnsembleIri
     *
     * @return Article
     */
    public function setSousEnsembleIri(string $sousEnsembleIri): Article
    {
        $this->sousEnsembleIri = $sousEnsembleIri;

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
     * @param string $numero
     *
     * @return Article
     */
    public function setNumero(string $numero): Article
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * @return string
     */
    public function getDecriptionInterne(): string
    {
        return $this->decriptionInterne;
    }

    /**
     * @param string $decriptionInterne
     *
     * @return Article
     */
    public function setDecriptionInterne(string $decriptionInterne): Article
    {
        $this->decriptionInterne = $decriptionInterne;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDecriptionExterne(): ?string
    {
        return $this->decriptionExterne;
    }

    /**
     * @param string|null $decriptionExterne
     *
     * @return Article
     */
    public function setDecriptionExterne(?string $decriptionExterne): Article
    {
        $this->decriptionExterne = $decriptionExterne;

        return $this;
    }

    /**
     * @return array
     */
    public function getCouleurIris(): array
    {
        return $this->couleurIris;
    }

    /**
     * @param string $couleurIri
     *
     * @return Article
     */
    public function addCouleurIri(string $couleurIri): Article
    {
        if (!\in_array($couleurIri, $this->couleurIris)) {
            $this->couleurIris[] = $couleurIri;
        }

        return $this;
    }

    /**
     * @param string $couleurIri
     *
     * @return Article
     */
    public function removeCouleurIri(string $couleurIri): Article
    {
        $this->couleurIris = \array_diff($this->couleurIris, [$couleurIri]);

        return $this;
    }

    /**
     * @return array
     */
    public function getMatiereIris(): array
    {
        return $this->matiereIris;
    }

    /**
     * @param string $matiereIris
     *
     * @return Article
     */
    public function addMatiereIri(string $matiereIris): Article
    {
        if (!\in_array($matiereIris, $this->matiereIris)) {
            $this->matiereIris[] = $matiereIris;
        }

        return $this;
    }

    /**
     * @param string $matiereIris
     *
     * @return Article
     */
    public function removeMatiereIri(string $matiereIris): Article
    {
        $this->matiereIris = \array_diff($this->matiereIris, [$matiereIris]);

        return $this;
    }

    /**
     * @return array
     */
    public function getPlanIris(): array
    {
        return $this->planIris;
    }

    /**
     * @param string $planIri
     *
     * @return Article
     */
    public function addPlanIri(string $planIri): Article
    {
        if (!\in_array($planIri, $this->planIris)) {
            $this->planIris[] = $planIri;
        }

        return $this;
    }

    /**
     * @param string $planIri
     *
     * @return Article
     */
    public function removePlanIri(string $planIri): Article
    {
        $this->planIris = \array_diff($this->planIris, [$planIri]);

        return $this;
    }

    /**
     * @return array
     */
    public function getTarifIris(): array
    {
        return $this->tarifIris;
    }

    /**
     * @param string $tarifIri
     *
     * @return Article
     */
    public function addTarifIri(string $tarifIri): Article
    {
        if (!\in_array($tarifIri, $this->tarifIris)) {
            $this->tarifIris[] = $tarifIri;
        }

        return $this;
    }

    /**
     * @param string $tarifIri
     *
     * @return Article
     */
    public function removeTarifIri(string $tarifIri): Article
    {
        $this->tarifIris = \array_diff($this->tarifIris, [$tarifIri]);

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