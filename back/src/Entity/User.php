<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "users")]
#[ORM\UniqueConstraint(name: "UNIQ_IDENTIFIER_EMAIL", fields: ["email"])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: "user", targetEntity: Recipe::class, cascade: ["remove"])]
    private iterable $recipes;

    #[ORM\OneToMany(mappedBy: "user", targetEntity: Message::class, cascade: ["remove"])]
    private iterable $messages;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email; // Utilisé pour l'authentification. LL
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function eraseCredentials(): void
    {
        // Si des données sensibles temporaires sont stockées, les effacer ici.
    }

    /**
     * Implémentation obligatoire de UserInterface, retourne un tableau vide car les rôles ne sont pas utilisés.
     */
    public function getRoles(): array
    {
        return [];
    }

    /**
     * @return iterable|Recipe[]
     */
    public function getRecipes(): iterable
    {
        return $this->recipes;
    }

    /**
     * @return iterable|Message[]
     */
    public function getMessages(): iterable
    {
        return $this->messages;
    }
}
