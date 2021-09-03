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
 *     denormalizationContext={"groups"={"article:write"}}
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
    private $versionIris = [];

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
     * @return bool
     */
    public function isValide(): bool
    {
        return $this->valide;
    }

    /**
     * @param bool $valide
     * @return Article
     */
    public function setValide(bool $valide): Article
    {
        $this->valide = $valide;
        return $this;
    }

    /**
     * @return array
     */
    public function getVersionIris(): array
    {
        return $this->versionIris;
    }

    /**
     * @param string $versionIri
     *
     * @return Article
     */
    public function addVersionIri(string $versionIri): Article
    {
        if (!\in_array($versionIri, $this->versionIris)) {
            $this->versionIris[] = $versionIri;
        }

        return $this;
    }

    /**
     * @param string $versionIri
     *
     * @return Article
     */
    public function removeVersionIri(string $versionIri): Article
    {
        $this->versionIris = \array_diff($this->versionIris, [$versionIri]);

        return $this;
    }
}