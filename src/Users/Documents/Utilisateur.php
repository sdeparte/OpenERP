<?php

namespace App\Users\Documents;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
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
 *          "getByUsername"={
 *              "route_name"="api_get_user_by_username",
 *          },
 *          "put"={"security"="is_granted('ROLE_ADMIN') or object == user"},
 *          "patch"={"security"="is_granted('ROLE_ADMIN') or object == user"},
 *          "delete"={"security"="is_granted('ROLE_ADMIN') or object == user"}
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
     * @ODM\Id(strategy="INCREMENT", type="string")
     *
     * @Groups("user:read")
     */
    private string $id;

    /**
     * @ODM\Field
     * @Assert\NotBlank
     *
     * @Groups({"user:read", "user:write"})
     */
    private string $pseudonym;

    /**
     * @ODM\Field
     * @Assert\NotBlank
     *
     * @Groups({"user:read", "user:write"})
     * @ApiProperty(identifier=true)
     */
    private string $username;

    /**
     * @SerializedName("password")
     * @Assert\NotBlank(groups={"create"})
     *
     * @Groups("user:write")
     */
    private ?string $plainPassword;

    /**
     * @ODM\Field
     */
    private string $password;

    /**
     * @ODM\Field
     */
    private ?string $salt = null;

    /**
     * @ODM\Field(type="collection")
     *
     * @Groups({"user:read", "user:write"})
     */
    private array $roles = [];

    /**
     * @ODM\Field(type="boolean")
     *
     * @Groups({"user:read", "user:write"})
     */
    private bool $visible = true;

    /**
     * @ODM\Field(type="boolean")
     *
     * @Groups({"user:read", "user:write"})
     */
    private bool $repondre = true;

    /**
     * @ODM\Field
     * @Iri({"Employe"})
     *
     * @Groups({"user:read", "user:write"})
     */
    private ?string $employeIri = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function setPseudonym(string $pseudonym): Utilisateur
    {
        $this->pseudonym = $pseudonym;

        return $this;
    }

    public function getPseudonym(): string
    {
        return $this->pseudonym;
    }

    public function setUsername(string $username): Utilisateur
    {
        $this->username = $username;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function __call(string $name, array $arguments)
    {
        return $this->username;
    }

    public function setPlainPassword(string $plainPassword): Utilisateur
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPassword(string $password): Utilisateur
    {
        $this->password = $password;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setSalt(?string $salt): Utilisateur
    {
        $this->salt = $salt;

        return $this;
    }

    public function getSalt(): ?string
    {
        return $this->salt;
    }

    public function setRoles(array $roles): Utilisateur
    {
        $this->roles = $roles;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setVisible(bool $visible): Utilisateur
    {
        $this->visible = $visible;

        return $this;
    }

    public function getVisible(): bool
    {
        return $this->visible;
    }

    public function setRepondre(bool $repondre): Utilisateur
    {
        $this->repondre = $repondre;

        return $this;
    }

    public function getRepondre(): bool
    {
        return $this->repondre;
    }

    public function getEmployeIri(): ?string
    {
        return $this->employeIri;
    }

    public function setEmployeIri(?string $employeIri): Utilisateur
    {
        $this->employeIri = $employeIri;

        return $this;
    }

    public function getDisplayName(): string
    {
        return $this->pseudonym.' ('.$this->username.')';
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }
}