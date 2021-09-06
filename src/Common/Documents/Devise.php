<?php

namespace App\Common\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ModelBundle\Validator\Iri;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource
 *
 * @ODM\Document
 */
class Devise
{
    /**
     * @ODM\Id(strategy="INCREMENT", type="int")
     */
    private int $id;

    /**
     * @ODM\Field
     * @Assert\NotBlank
     */
    private string $nom;

    /**
     * @ODM\Field
     * @Assert\NotBlank
     */
    private string $abreviation;

    /**
     * @ODM\Field
     * @Assert\NotBlank
     */
    private string $symbole;

    public function getId(): int
    {
        return $this->id;
    }

    public function setNom(string $nom): Devise
    {
        $this->nom = ucfirst($nom);

        return $this;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setAbreviation(string $abreviation): Devise
    {
        $this->abreviation = strtoupper($abreviation);

        return $this;
    }

    public function getAbreviation(): string
    {
        return $this->abreviation;
    }

    public function setSymbole(string $symbole): Devise
    {
        $this->symbole = $symbole;

        return $this;
    }

    public function getSymbole(): string
    {
        return $this->symbole;
    }

    public function getDisplayName(): string
    {
        return $this->symbole.' - '.$this->nom;
    }
}