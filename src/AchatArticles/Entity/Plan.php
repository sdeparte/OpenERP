<?php
/**
 * Property of ProwebCe.
 */

namespace App\AchatArticles\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Plan
 *
 * @ORM\Table(name="plan")
 * @ORM\Entity(repositoryClass="App\AchatArticles\Repository\PlanRepository")
 */
class Plan
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="fichier", type="string", length=255)
     */
    private $fichier;

    /**
     * @ORM\ManyToOne(targetEntity="App\AchatArticles\Entity\Article", inversedBy="plans")
     */
    private $article;

    /**
     * @var string
     *
     * @ORM\Column(name="indice", type="string", length=5)
     */
    private $indice = "A";

    /**
     * @var string
     */
    private $temporaryPlan;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Plan
     */
    public function setNom($nom): Plan
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
     * Set description
     *
     * @param string $description
     *
     * @return Plan
     */
    public function setDescription($description): Plan
    {
        $this->description = ucfirst($description);

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set fichier
     *
     * @param string $fichier
     *
     * @return Plan
     */
    public function setFichier($fichier): Plan
    {
        $this->fichier = $fichier;

        return $this;
    }

    /**
     * Get fichier
     *
     * @return string
     */
    public function getFichier(): string
    {
        return $this->fichier;
    }

    /**
     * Set article
     *
     * @param Article $article
     *
     * @return Plan
     */
    public function setArticle(Article $article = null): Plan
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return Article
     */
    public function getArticle(): Article
    {
        return $this->article;
    }

    /**
     * Set indice
     *
     * @param string $indice
     *
     * @return Plan
     */
    public function setIndice($indice): Plan
    {
        $this->indice = $indice;

        return $this;
    }

    /**
     * Get indice
     *
     * @return string
     */
    public function getIndice(): string
    {
        return $this->indice;
    }

    /**
     * Get display name
     *
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->indice.' - '.$this->nom;
    }
}
