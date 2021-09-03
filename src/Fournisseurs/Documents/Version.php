<?php

namespace App\Fournisseurs\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ModelBundle\Validator\Iri;
use App\ModelBundle\Validator\Unique;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Version
 *
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
     * @var int
     *
     * @ODM\Id(strategy="INCREMENT", type="int")
     *
     * @Groups({"version:read"})
     */
    private $id;

    /**
     * @var string
     *
     * @ODM\Field
     * @Assert\NotBlank
     *
     * @Groups({"version:read"})
     */
    private $lettres = 'A';

    /**
     * @var string
     *
     * @ODM\Field
     * @Iri("Fournisseurs")
     *
     * @Groups({"version:read", "version:write"})
     */
    private $articleIri;

    /**
     * @var array
     *
     * @ODM\Field(type="collection")
     *
     * @Groups({"version:read"})
     */
    private $referenceFournisseurIris = [];

    /**
     * @var array
     *
     * @ODM\Field(type="collection")
     *
     * @Groups({"version:read"})
     */
    private $parametreIris = [];

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
    public function getLettres(): string
    {
        return $this->lettres;
    }

    /**
     * @param string $lettres
     *
     * @return Version
     */
    public function setLettres(string $lettres): Version
    {
        $this->lettres = $lettres;

        return $this;
    }

    /**
     * @return string
     */
    public function getArticleIri(): string
    {
        return $this->articleIri;
    }

    /**
     * @param string $articleIri
     *
     * @return Version
     */
    public function setArticleIri(string $articleIri): Version
    {
        $this->articleIri = $articleIri;

        return $this;
    }

    /**
     * @return array
     */
    public function getReferenceFournisseurIris(): array
    {
        return $this->referenceFournisseurIris;
    }

    /**
     * @param string $referenceFournisseurIri
     *
     * @return Version
     */
    public function addReferenceFournisseurIri(string $referenceFournisseurIri): Version
    {
        if (!\in_array($referenceFournisseurIri, $this->referenceFournisseurIris)) {
            $this->referenceFournisseurIris[] = $referenceFournisseurIri;
        }

        return $this;
    }

    /**
     * @param string $referenceFournisseurIri
     *
     * @return Version
     */
    public function removeReferenceFournisseurIri(string $referenceFournisseurIri): Version
    {
        $this->referenceFournisseurIris = \array_diff($this->referenceFournisseurIris, [$referenceFournisseurIri]);

        return $this;
    }

    /**
     * @return array
     */
    public function getParametreIris(): array
    {
        return $this->parametreIris;
    }

    /**
     * @param string $parametreIri
     *
     * @return Version
     */
    public function addParametreIri(string $parametreIri): Version
    {
        if (!\in_array($parametreIri, $this->parametreIris)) {
            $this->parametreIris[] = $parametreIri;
        }

        return $this;
    }

    /**
     * @param string $parametreIri
     *
     * @return Version
     */
    public function removeParametreIri(string $parametreIri): Version
    {
        $this->parametreIris = \array_diff($this->parametreIris, [$parametreIri]);

        return $this;
    }
}