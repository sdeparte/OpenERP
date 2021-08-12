<?php
/**
 * Property of ProwebCe.
 */

namespace App\AchatArticles\Entity;

use Doctrine\ORM\Mapping as ORM;

class Article
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
     * @ORM\Column(name="num", type="string", length=6)
     */
    private $num = "000001";

    /**
     * @var string
     *
     * @ORM\Column(name="description_1", type="string", length=255)
     */
    private $description1 = '';

    /**
     * @var string
     *
     * @ORM\Column(name="description_2", nullable=true, type="string", length=255)
     */
    private $description2 = '';

    /**
     * @var bool
     *
     * @ORM\Column(name="valide", type="boolean")
     */
    private $valide = false;

    /**
     * @ORM\ManyToOne(targetEntity="SD\ComptabiliteBundle\Entity\CompteComptable")
     */
    private $compteComptable;

    /**
     * @ORM\ManyToOne(targetEntity="SD\ArticleAchatBundle\Entity\SousEnsemble")
     */
    private $sousEnsemble;

    /**
     * @ORM\OneToMany(targetEntity="SD\ArticleAchatBundle\Entity\ArticleCouleur", mappedBy="article", cascade={"persist", "remove"})
     */
    private $couleurs;

    /**
     * @ORM\OneToMany(targetEntity="SD\ArticleAchatBundle\Entity\ArticleMatiere", mappedBy="article", cascade={"persist", "remove"})
     */
    private $matieres;

    /**
     * @ORM\OneToMany(targetEntity="SD\ArticleAchatBundle\Entity\ArticleTypeUsinage", mappedBy="article", cascade={"persist", "remove"})
     */
    private $typeUsinages;

    /**
     * @ORM\OneToMany(targetEntity="SD\ArticleAchatBundle\Entity\Plan", mappedBy="article", cascade={"persist", "remove"})
     */
    private $plans;

    /**
     * @ORM\OneToMany(targetEntity="SD\ArticleAchatBundle\Entity\ArticleReferenceFournisseur", mappedBy="article", cascade={"persist", "remove"})
     */
    private $referencesFournisseurs;

    /**
     * @ORM\OneToMany(targetEntity="SD\ArticleAchatBundle\Entity\Tarif", mappedBy="article", cascade={"persist", "remove"})
     */
    private $tarifs;

    /**
     * @ORM\OneToMany(targetEntity="SD\ArticleAchatBundle\Entity\ArticleArticle", mappedBy="sourceArticle", cascade={"persist", "remove"})
     */
    private $articles;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->couleurs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->matieres = new \Doctrine\Common\Collections\ArrayCollection();
        $this->typeUsinages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->plans = new \Doctrine\Common\Collections\ArrayCollection();
        $this->referencesFournisseurs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tarifs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->articles = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set id
     *
     * @param id $id
     *
     * @return ArticleArticle
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set num
     *
     * @param string $num
     *
     * @return Article
     */
    public function setNum($num)
    {
        $this->num = $num;

        return $this;
    }

    /**
     * Get num
     *
     * @return string
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * Set description1
     *
     * @param string $description1
     *
     * @return Article
     */
    public function setDescription1($description1)
    {
        $this->description1 = $description1;

        return $this;
    }

    /**
     * Get description1
     *
     * @return string
     */
    public function getDescription1()
    {
        return $this->description1;
    }

    /**
     * Set description2
     *
     * @param string $description2
     *
     * @return Article
     */
    public function setDescription2($description2)
    {
        $this->description2 = $description2;

        return $this;
    }

    /**
     * Get description2
     *
     * @return string
     */
    public function getDescription2()
    {
        return $this->description2;
    }

    /**
     * Set valide
     *
     * @param boolean $valide
     *
     * @return Article
     */
    public function setValide($valide)
    {
        $this->valide = $valide;

        return $this;
    }

    /**
     * Get valide
     *
     * @return boolean
     */
    public function getValide()
    {
        return $this->valide;
    }

    /**
     * Set compteComptable
     *
     * @param \SD\ComptabiliteBundle\Entity\CompteComptable $compteComptable
     *
     * @return Article
     */
    public function setCompteComptable(\SD\ComptabiliteBundle\Entity\CompteComptable $compteComptable = null)
    {
        $this->compteComptable = $compteComptable;

        return $this;
    }

    /**
     * Get compteComptable
     *
     * @return \SD\ComptabiliteBundle\Entity\CompteComptable
     */
    public function getCompteComptable()
    {
        return $this->compteComptable;
    }

    /**
     * Set sousEnsemble
     *
     * @param \SD\ArticleAchatBundle\Entity\SousEnsemble $sousEnsemble
     *
     * @return Article
     */
    public function setSousEnsemble(\SD\ArticleAchatBundle\Entity\SousEnsemble $sousEnsemble = null)
    {
        $this->sousEnsemble = $sousEnsemble;

        return $this;
    }

    /**
     * Get sousEnsemble
     *
     * @return \SD\ArticleAchatBundle\Entity\SousEnsemble
     */
    public function getSousEnsemble()
    {
        return $this->sousEnsemble;
    }

    /**
     * Add couleur
     *
     * @param \SD\ArticleAchatBundle\Entity\ArticleCouleur $couleur
     *
     * @return Article
     */
    public function addCouleur(\SD\ArticleAchatBundle\Entity\ArticleCouleur $couleur)
    {
        $this->couleurs[] = $couleur;

        return $this;
    }

    /**
     * Remove couleur
     *
     * @param \SD\ArticleAchatBundle\Entity\ArticleCouleur $couleur
     */
    public function removeCouleur(\SD\ArticleAchatBundle\Entity\ArticleCouleur $couleur)
    {
        $this->couleurs->removeElement($couleur);
    }

    /**
     * Get couleurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCouleurs()
    {
        return $this->couleurs;
    }

    /**
     * Add matiere
     *
     * @param \SD\ArticleAchatBundle\Entity\ArticleMatiere $matiere
     *
     * @return Article
     */
    public function addMatiere(\SD\ArticleAchatBundle\Entity\ArticleMatiere $matiere)
    {
        $this->matieres[] = $matiere;

        return $this;
    }

    /**
     * Remove matiere
     *
     * @param \SD\ArticleAchatBundle\Entity\ArticleMatiere $matiere
     */
    public function removeMatiere(\SD\ArticleAchatBundle\Entity\ArticleMatiere $matiere)
    {
        $this->matieres->removeElement($matiere);
    }

    /**
     * Get matieres
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMatieres()
    {
        return $this->matieres;
    }

    /**
     * Add typeUsinage
     *
     * @param \SD\ArticleAchatBundle\Entity\ArticleTypeUsinage $typeUsinage
     *
     * @return Article
     */
    public function addTypeUsinage(\SD\ArticleAchatBundle\Entity\ArticleTypeUsinage $typeUsinage)
    {
        $this->typeUsinages[] = $typeUsinage;

        return $this;
    }

    /**
     * Remove typeUsinage
     *
     * @param \SD\ArticleAchatBundle\Entity\ArticleTypeUsinage $typeUsinage
     */
    public function removeTypeUsinage(\SD\ArticleAchatBundle\Entity\ArticleTypeUsinage $typeUsinage)
    {
        $this->typeUsinages->removeElement($typeUsinage);
    }

    /**
     * Get typeUsinages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTypeUsinages()
    {
        return $this->typeUsinages;
    }

    /**
     * Add plan
     *
     * @param \SD\ArticleAchatBundle\Entity\Plan $plan
     *
     * @return Article
     */
    public function addPlan(\SD\ArticleAchatBundle\Entity\Plan $plan)
    {
        $this->plans[] = $plan;

        return $this;
    }

    /**
     * Remove plan
     *
     * @param \SD\ArticleAchatBundle\Entity\Plan $plan
     */
    public function removePlan(\SD\ArticleAchatBundle\Entity\Plan $plan)
    {
        $this->plans->removeElement($plan);
    }

    /**
     * Get plans
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlans()
    {
        return $this->plans;
    }

    /**
     * Add referencesFournisseur
     *
     * @param \SD\ArticleAchatBundle\Entity\ArticleReferenceFournisseur $referencesFournisseur
     *
     * @return Article
     */
    public function addReferencesFournisseur(\SD\ArticleAchatBundle\Entity\ArticleReferenceFournisseur $referencesFournisseur)
    {
        $this->referencesFournisseurs[] = $referencesFournisseur;

        return $this;
    }

    /**
     * Remove referencesFournisseur
     *
     * @param \SD\ArticleAchatBundle\Entity\ArticleReferenceFournisseur $referencesFournisseur
     */
    public function removeReferencesFournisseur(\SD\ArticleAchatBundle\Entity\ArticleReferenceFournisseur $referencesFournisseur)
    {
        $this->referencesFournisseurs->removeElement($referencesFournisseur);
    }

    /**
     * Get referencesFournisseurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReferencesFournisseurs()
    {
        return $this->referencesFournisseurs;
    }

    /**
     * Add tarif
     *
     * @param \SD\ArticleAchatBundle\Entity\Tarif $tarif
     *
     * @return Article
     */
    public function addTarif(\SD\ArticleAchatBundle\Entity\Tarif $tarif)
    {
        $this->tarifs[] = $tarif;

        return $this;
    }

    /**
     * Remove tarif
     *
     * @param \SD\ArticleAchatBundle\Entity\Tarif $tarif
     */
    public function removeTarif(\SD\ArticleAchatBundle\Entity\Tarif $tarif)
    {
        $this->tarifs->removeElement($tarif);
    }

    /**
     * Get tarifs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTarifs()
    {
        return $this->tarifs;
    }

    /**
     * Add article
     *
     * @param \SD\ArticleAchatBundle\Entity\ArticleArticle $article
     *
     * @return Article
     */
    public function addArticle(\SD\ArticleAchatBundle\Entity\ArticleArticle $article)
    {
        $this->articles[] = $article;

        return $this;
    }

    /**
     * Remove article
     *
     * @param \SD\ArticleAchatBundle\Entity\ArticleArticle $article
     */
    public function removeArticle(\SD\ArticleAchatBundle\Entity\ArticleArticle $article)
    {
        $this->articles->removeElement($article);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * Get display name
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->sousEnsemble->getType()->getLettre().$this->sousEnsemble->getNum().$this->num;
    }
}
