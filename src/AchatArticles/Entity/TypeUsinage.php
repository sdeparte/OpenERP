<?php
/**
 * Property of ProwebCe.
 */

namespace App\AchatArticles\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * TypeUsinage
 *
 * @ORM\Table(name="type_usinage")
 * @ORM\Entity(repositoryClass="App\AchatArticles\Repository\TypeUsinageRepository")
 * @UniqueEntity(fields="nom", message="Un type d'usinage existe déjà avec ce nom.")
 */
class TypeUsinage
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
     * @return TypeUsinage
     */
    public function setNom($nom): TypeUsinage
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
}
