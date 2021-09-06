<?php

namespace App\Fournisseurs\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ModelBundle\Validator\Iri;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
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
     * @Groups({"article:read"})
     */
    private $id;

    /**
     * @ODM\ReferenceOne(targetDocument=SousEnsemble::class)
     *
     * @Groups({"article:read", "article:write"})
     */
    private SousEnsemble $sousEnsembleIri;

    /**
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
    private string $numero = "000001";

    /**
     * @ODM\Field
     * @Assert\NotBlank
     *
     * @Groups({"article:read", "article:write"})
     */
    private string $decriptionInterne;

    /**
     * @ODM\Field
     *
     * @Groups({"article:read", "article:write"})
     */
    private ?string $decriptionExterne = null;

    /**
     * @ODM\Field(type="boolean")
     *
     * @Groups({"article:read", "article:write"})
     */
    private bool $valide = false;

    /**
     * @ODM\EmbedMany(targetDocument=Version::class)
     *
     * @Groups({"article:read"})
     */
    private Collection $versionIris;

    public function __construct()
    {
        $this->versionIris = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSousEnsembleIri(): SousEnsemble
    {
        return $this->sousEnsembleIri;
    }

    public function setSousEnsembleIri(SousEnsemble $sousEnsembleIri): Article
    {
        $this->sousEnsembleIri = $sousEnsembleIri;

        return $this;
    }

    public function getNumero(): string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): Article
    {
        $this->numero = $numero;

        return $this;
    }

    public function getDecriptionInterne(): string
    {
        return $this->decriptionInterne;
    }

    public function setDecriptionInterne(string $decriptionInterne): Article
    {
        $this->decriptionInterne = $decriptionInterne;

        return $this;
    }

    public function getDecriptionExterne(): ?string
    {
        return $this->decriptionExterne;
    }

    public function setDecriptionExterne(?string $decriptionExterne): Article
    {
        $this->decriptionExterne = $decriptionExterne;

        return $this;
    }

    public function isValide(): bool
    {
        return $this->valide;
    }

    public function setValide(bool $valide): Article
    {
        $this->valide = $valide;

        return $this;
    }

    public function getVersionIris(): Collection
    {
        return $this->versionIris;
    }

    public function addVersionIri(Version $versionIri): Article
    {
        if (!$this->versionIris->contains($versionIri)) {
            $this->versionIris->add($versionIri);
        }

        return $this;
    }

    public function removeVersionIri(Version $versionIri): Article
    {
        if ($this->versionIris->contains($versionIri)) {
            $this->versionIris->removeElement($versionIri);
        }

        return $this;
    }
}