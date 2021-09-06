<?php

namespace App\Fournisseurs\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ModelBundle\Validator\Iri;
use App\ModelBundle\Validator\Unique;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"version:read"}},
 *     denormalizationContext={"groups"={"version:write"}}
 * )
 *
 * @ODM\Document(repositoryClass="App\Fournisseurs\Repositories\VersionRepository")
 * @Unique(self::class, fields={"lettre"}, message="Un traitement existe déjà avec ce nom.")
 */
class Version
{
    /**
     * @ODM\Id(strategy="INCREMENT", type="int")
     *
     * @Groups({"version:read"})
     */
    private int $id;

    /**
     * @ODM\Field
     * @Assert\NotBlank
     *
     * @Groups({"article:read", "version:read"})
     */
    private string $lettres = 'A';

    /**
     * @ODM\ReferenceOne(targetDocument=Article::class)
     *
     * @Groups({"article:read", "version:read", "version:write"})
     */
    private Article $articleIri;

    /**
     * @ODM\EmbedMany(targetDocument=ReferenceFournisseur::class)
     *
     * @Groups({"article:read", "version:read"})
     */
    private Collection $referenceFournisseurIris;

    /**
     * @ODM\EmbedMany(targetDocument=Parametre::class)
     *
     * @Groups({"article:read", "version:read"})
     */
    private Collection $parametreIris;

    public function __construct()
    {
        $this->referenceFournisseurIris = new ArrayCollection();
        $this->parametreIris = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLettres(): string
    {
        return $this->lettres;
    }

    public function setLettres(string $lettres): Version
    {
        $this->lettres = $lettres;

        return $this;
    }

    public function getArticleIri(): Article
    {
        return $this->articleIri;
    }

    public function setArticleIri(Article $articleIri): Version
    {
        $this->articleIri = $articleIri;

        return $this;
    }

    public function getReferenceFournisseurIris(): Collection
    {
        return $this->referenceFournisseurIris;
    }

    public function addReferenceFournisseurIri(ReferenceFournisseur $referenceFournisseurIri): Version
    {
        if (!$this->referenceFournisseurIris->contains($referenceFournisseurIri)) {
            $this->referenceFournisseurIris->add($referenceFournisseurIri);
        }

        return $this;
    }

    public function removeReferenceFournisseurIri(ReferenceFournisseur $referenceFournisseurIri): Version
    {
        if (!$this->referenceFournisseurIris->contains($referenceFournisseurIri)) {
            $this->referenceFournisseurIris->add($referenceFournisseurIri);
        }

        return $this;
    }

    public function getParametreIris(): Collection
    {
        return $this->parametreIris;
    }

    public function addParametreIri(Parametre $parametreIri): Version
    {
        if (!$this->parametreIris->contains($parametreIri)) {
            $this->parametreIris->add($parametreIri);
        }

        return $this;
    }

    public function removeParametreIri(Parametre $parametreIri): Version
    {
        if (!$this->parametreIris->contains($parametreIri)) {
            $this->parametreIris->add($parametreIri);
        }

        return $this;
    }
}