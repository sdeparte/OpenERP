<?php
/**
 * Property of ProwebCe.
 */

namespace App\AchatArticles\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * SousEnsemble
 *
 * @ORM\Table(name="sous_ensemble")
 * @ORM\Entity(repositoryClass="App\AchatArticles\Repository\TypeSousEnsembleRepository")
 * @UniqueEntity(fields="lettre", message="Un type de sous ensemble existe déjà avec cette lettre.")
 */
class SousEnsemble
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
     * @ORM\ManyToOne(targetEntity="SD\ArticleAchatBundle\Entity\TypeSousEnsemble", inversedBy="sousEnsembles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="num", type="string", length=2)
     * @Assert\Length(
     *      min = 2,
     *      max = 2,
     *      exactMessage = "Un numéro de sous ensemble doit être composé de {{ limit }} caractères"
     * )
     */
    private $num;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;


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
     * Set type
     *
     * @param TypeSousEnsemble $type
     *
     * @return SousEnsemble
     */
    public function setType(TypeSousEnsemble $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return TypeSousEnsemble
     */
    public function getType(): TypeSousEnsemble
    {
        return $this->type;
    }

    /**
     * Set num
     *
     * @param string $num
     *
     * @return SousEnsemble
     */
    public function setNum($num): SousEnsemble
    {
        $this->num = $num;

        return $this;
    }

    /**
     * Get num
     *
     * @return string
     */
    public function getNum(): string
    {
        return $this->num;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return SousEnsemble
     */
    public function setNom($nom): SousEnsemble
    {
        $this->nom = ucfirst($nom);

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
     * Get display name
     *
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->num.' - '.$this->nom;
    }
}
