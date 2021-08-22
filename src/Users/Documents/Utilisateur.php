<?php

namespace App\Users\Documents;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\MongoDbOdm\Filter\SearchFilter;
use App\ModelBundle\Validator\Iri;
use App\ModelBundle\Validator\Unique;
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
 *          "get",
 *          "post"={
 *              "security"="is_granted('ROLE_ADMIN')",
 *              "validation_groups"={"Default", "create"},
 *          },
 *     },
 *     itemOperations={
 *          "get",
 *          "put"={"security"="is_granted('ROLE_ADMIN') or object == user"},
 *     },
 * )
 *
 * @ApiFilter(SearchFilter::class, properties={"id": "exact", "username": "exact"})
 *
 * @ODM\Document
 * @Unique(self::class, fields="username")
 *
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
    private $pseudonym;

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
     * @var array
     *
     * @ODM\Field(type="collection")
     *
     * @Groups({"user:read", "user:write"})
     */
    private $roles = null;

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
    private $employeIri = null;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $pseudonym
     *
     * @return Utilisateur
     */
    public function setPseudonym(string $pseudonym): Utilisateur
    {
        $this->pseudonym = $pseudonym;

        return $this;
    }

    /**
     * @return string
     */
    public function getPseudonym(): string
    {
        return $this->pseudonym;
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
     * @return Utilisateur
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
     * @param array $roles
     *
     * @return Utilisateur
     */
    public function setRoles(array $roles): Utilisateur
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
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
     * @return Utilisateur
     */
    public function setEmployeIri(?string $employeIri): Utilisateur
    {
        $this->employeIri = $employeIri;

        return $this;
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->pseudonym.' ('.$this->username.')';
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }
}