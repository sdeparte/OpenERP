<?php
/**
 * Property of ProwebCe.
 */

namespace App\AchatArticles\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * TypeSousEnsemble
 *
 * @ORM\Table(name="type_sous_ensemble_achat")
 * @ORM\Entity(repositoryClass="App\AchatArticles\Repository\TypeSousEnsembleRepository")
 * @UniqueEntity(fields="lettre", message="Un type de sous ensemble existe déjà avec cette lettre.")
 */
class TypeSousEnsemble
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="lettre", type="string", length=1)
     */
    private $lettre;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var bool
     *
     * @ORM\Column(name="isAssemblage", type="boolean")
     */
    private $isAssemblage;

    /**
     * @ORM\OneToMany(targetEntity="App\AchatArticle\Entity\SousEnsemble", mappedBy="type", cascade={"persist", "remove"})
     */
    private $sousEnsembles;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sousEnsembles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set lettre
     *
     * @param string $lettre
     *
     * @return TypeSousEnsemble
     */
    public function setLettre($lettre): TypeSousEnsemble
    {
        $this->lettre = $lettre;

        return $this;
    }

    /**
     * Get lettre
     *
     * @return string
     */
    public function getLettre(): string
    {
        return $this->lettre;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return TypeSousEnsemble
     */
    public function setNom($nom): TypeSousEnsemble
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * Set isAssemblage
     *
     * @param boolean $isAssemblage
     *
     * @return TypeSousEnsemble
     */
    public function setIsAssemblage($isAssemblage): TypeSousEnsemble
    {
        $this->isAssemblage = $isAssemblage;

        return $this;
    }

    /**
     * Get isAssemblage
     *
     * @return bool
     */
    public function getIsAssemblage(): bool
    {
        return $this->isAssemblage;
    }

    /**
     * Add sousEnsemble
     *
     * @param SousEnsemble $sousEnsemble
     *
     * @return TypeSousEnsemble
     */
    public function addSousEnsemble(SousEnsemble $sousEnsemble): TypeSousEnsemble
    {
        $this->sousEnsembles[] = $sousEnsemble;

        return $this;
    }

    /**
     * Remove sousEnsemble
     *
     * @param SousEnsemble $sousEnsemble
     *
     * @return TypeSousEnsemble
     */
    public function removeSousEnsemble(SousEnsemble $sousEnsemble): TypeSousEnsemble
    {
        $this->sousEnsembles->removeElement($sousEnsemble);

        return $this;
    }

    /**
     * Get sousEnsembles
     *
     * @return Collection
     */
    public function getSousEnsembles(): Collection
    {
        return $this->sousEnsembles;
    }

    /**
     * Get display name
     *
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->lettre.' - '.$this->nom;
    }
}
