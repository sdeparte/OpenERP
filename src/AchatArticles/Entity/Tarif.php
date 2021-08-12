<?php
/**
 * Property of ProwebCe.
 */

namespace App\AchatArticles\Entity;

use App\CommonBundle\Entity\Couleur;
use App\CommonBundle\Entity\Matiere;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Tarif
 *
 * @ORM\Table(name="tarif_achat")
 * @ORM\Entity(repositoryClass="SD\ArticleAchatBundle\Repository\TarifRepository")
 */
class Tarif
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
     * @ORM\Column(name="devis", type="string", length=255, nullable=true)
     */
    private $devis;

    /**
     * @var float
     *
     * @ORM\Column(name="quantite", type="float")
     * @Assert\Type(
     *     type="float",
     *     message="{{ value }} n'est pas une quantité valide."
     * )
     */
    private $quantite;

    /**
     * @var float
     *
     * @ORM\Column(name="prixUnitHT", type="float")
     * @Assert\Type(
     *     type="float",
     *     message="{{ value }} n'est pas un prix unitaire valide."
     * )
     */
    private $prixUnitHT;

    /**
     * @Iri("Common")
     */
    private $devise;

    /**
     * @ORM\ManyToOne(targetEntity="SD\ArticleAchatBundle\Entity\ArticleReferenceFournisseur")
     */
    private $referenceFournisseur;

    /**
     * @ORM\ManyToOne(targetEntity="SD\ArticleAchatBundle\Entity\Plan")
     */
    private $plan;

    /**
     * @ORM\ManyToOne(targetEntity="SD\ArticleAchatBundle\Entity\Couleur")
     */
    private $couleur;

    /**
     * @ORM\ManyToOne(targetEntity="SD\ArticleAchatBundle\Entity\Matiere")
     */
    private $matiere;

    /**
     * @ORM\ManyToOne(targetEntity="SD\ArticleAchatBundle\Entity\Article", inversedBy="tarifs")
     */
    private $article;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set devis
     *
     * @param string $devis
     *
     * @return Tarif
     */
    public function setDevis($devis)
    {
        $this->devis = $devis;

        return $this;
    }

    /**
     * Get devis
     *
     * @return string
     */
    public function getDevis()
    {
        return $this->devis;
    }

    /**
     * Set quantite
     *
     * @param float $quantite
     *
     * @return Tarif
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return float
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set prixUnitHT
     *
     * @param float $prixUnitHT
     *
     * @return Tarif
     */
    public function setPrixUnitHT($prixUnitHT)
    {
        $this->prixUnitHT = $prixUnitHT;

        return $this;
    }

    /**
     * Get prixUnitHT
     *
     * @return float
     */
    public function getPrixUnitHT()
    {
        return $this->prixUnitHT;
    }

    /**
     * Set devise
     *
     * @param \SD\CommonBundle\Entity\Devise $devise
     *
     * @return Tarif
     */
    public function setDevise(\SD\CommonBundle\Entity\Devise $devise = null)
    {
        $this->devise = $devise;

        return $this;
    }

    /**
     * Get devise
     *
     * @return \SD\CommonBundle\Entity\Devise
     */
    public function getDevise()
    {
        return $this->devise;
    }

    /**
     * Set referenceFournisseur
     *
     * @param \SD\ArticleAchatBundle\Entity\ArticleReferenceFournisseur $referenceFournisseur
     *
     * @return Tarif
     */
    public function setReferenceFournisseur(\SD\ArticleAchatBundle\Entity\ArticleReferenceFournisseur $referenceFournisseur = null)
    {
        $this->referenceFournisseur = $referenceFournisseur;

        return $this;
    }

    /**
     * Get referenceFournisseur
     *
     * @return \SD\ArticleAchatBundle\Entity\ArticleReferenceFournisseur
     */
    public function getReferenceFournisseur()
    {
        return $this->referenceFournisseur;
    }

    /**
     * Set plan
     *
     * @param Plan|null $plan
     *
     * @return Tarif
     */
    public function setPlan(?Plan $plan = null): Tarif
    {
        $this->plan = $plan;

        return $this;
    }

    /**
     * Get plan
     *
     * @return Plan|null
     */
    public function getPlan(): ?Plan
    {
        return $this->plan;
    }

    /**
     * Set couleur
     *
     * @param Couleur|null $couleur
     *
     * @return Tarif
     */
    public function setCouleur(?Couleur $couleur = null): Tarif
    {
        $this->couleur = $couleur;

        return $this;
    }

    /**
     * Get couleur
     *
     * @return Couleur|null
     */
    public function getCouleur(): ?Couleur
    {
        return $this->couleur;
    }

    /**
     * Set matiere
     *
     * @param Matiere|null $matiere
     *
     * @return Tarif
     */
    public function setMatiere(?Matiere $matiere = null): Tarif
    {
        $this->matiere = $matiere;

        return $this;
    }

    /**
     * Get matiere
     *
     * @return Matiere|null
     */
    public function getMatiere(): ?Matiere
    {
        return $this->matiere;
    }

    /**
     * Set article
     *
     * @param Article|null $article
     *
     * @return Tarif
     */
    public function setArticle(?Article $article = null): Tarif
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return Article|null
     */
    public function getArticle(): ?Article
    {
        return $this->article;
    }

    /**
     * Get prix total
     *
     * @return float
     */
    public function getPrixTotal(): float
    {
        return $this->prixUnitHT * $this->quantite;
    }
}
