<?php

namespace App\Users\Documents;

use ApiPlatform\Core\Annotation\ApiResource;
use App\ModelBundle\Validator\Iri;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Utilisateur
 *
 * @ApiResource(
 *     normalizationContext={"groups"={"user:read"}},
 *     denormalizationContext={"groups"={"user:write"}},
 *     collectionOperations={
 *          "post"={
 *              "validation_groups"={"Default", "create"},
 *          },
 *     },
 * )
 *
 * @ODM\Document
 * @method string getUserIdentifier()
 */
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{

    /**
     * @var int
     *
     * @ODM\Id(strategy="INCREMENT", type="int")
     *
     * @Groups("user:read")
     */
    private $id;

    /**
     * @var string
     *
     * @ODM\Field
     * @Assert\NotBlank
     *
     * @Groups({"user:read", "user:write"})
     */
    private $pseudonyme;

    /**
     * @var string
     *
     * @ODM\Field
     * @Assert\NotBlank
     *
     * @Groups({"user:read", "user:write"})
     */
    private $username;

    /**
     * @var string
     *
     * @SerializedName("password")
     * @Assert\NotBlank(groups={"create"})
     *
     * @Groups("user:write")
     */
    private $plainPassword;

    /**
     * @var string
     *
     * @ODM\Field
     */
    private $password;

    /**
     * @var string|null
     *
     * @ODM\Field
     */
    private $salt = null;

    /**
     * @var bool
     *
     * @ODM\Field(type="boolean")
     *
     * @Groups({"user:read", "user:write"})
     */
    private $visible = true;

    /**
     * @var bool
     *
     * @ODM\Field(type="boolean")
     *
     * @Groups({"user:read", "user:write"})
     */
    private $repondre = true;

    /**
     * @var string|null
     *
     * @ODM\Field
     * @Iri("Employes")
     *
     * @Groups({"user:read", "user:write"})
     */
    private $employeIri;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $pseudonyme
     *
     * @return Utilisateur
     */
    public function setPseudonyme(string $pseudonyme): Utilisateur
    {
        $this->pseudonyme = $pseudonyme;

        return $this;
    }

    /**
     * @return string
     */
    public function getPseudonyme(): string
    {
        return $this->pseudonyme;
    }

    /**
     * @param string $username
     *
     * @return Utilisateur
     */
    public function setUsername(string $username): Utilisateur
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $name
     * @param array $arguments
     *
     * @return string
     */
    public function __call(string $name, array $arguments)
    {
        return $this->username;
    }

    /**
     * @param string $plainPassword
     *
     * @return Utilisateur
     */
    public function setPlainPassword(string $plainPassword): Utilisateur
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string|null $password
     *
     * @return Utilisateur
     */
    public function setPassword(?string $password): Utilisateur
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string|null $salt
     *
     * @return $this
     */
    public function setSalt(?string $salt): Utilisateur
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSalt(): ?string
    {
        return $this->salt;
    }

    /**
     * @param boolean $visible
     *
     * @return Utilisateur
     */
    public function setVisible(bool $visible): Utilisateur
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * @return bool
     */
    public function getVisible(): bool
    {
        return $this->visible;
    }

    /**
     * @param boolean $repondre
     *
     * @return Utilisateur
     */
    public function setRepondre(bool $repondre): Utilisateur
    {
        $this->repondre = $repondre;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getRepondre(): bool
    {
        return $this->repondre;
    }

    /**
     * @return string|null
     */
    public function getEmployeIri(): ?string
    {
        return $this->employeIri;
    }

    /**
     * @param string|null $employeIri
     *
     * @return $this
     */
    public function setEmployeIri(?string $employeIri): Utilisateur
    {
        $this->employeIri = $employeIri;

        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return array('ROLE_USER');
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->pseudonyme.' ('.$this->username.')';
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }
}