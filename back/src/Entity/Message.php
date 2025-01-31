<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use App\Entity\Recipe;

#[ORM\Entity]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "text")]
    private string $content;

    #[ORM\Column(type: "datetime", options: ["default" => "CURRENT_TIMESTAMP"])]
    private \DateTimeInterface $sentAt;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")] // 🔥 Suppression en cascade si l'utilisateur est supprimé
    private User $user;

    #[ORM\ManyToOne(targetEntity: Recipe::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")] // 🔥 Suppression en cascade si la recette est supprimée
    private Recipe $recipe;

    public function __construct()
    {
        $this->sentAt = new \DateTime(); // ✅ Définit une valeur par défaut pour éviter les erreurs
    }

    public function getId(): ?int 
    { 
        return $this->id; 
    }

    public function getContent(): string 
    { 
        return $this->content; 
    }

    public function setContent(string $content): static 
    { 
        $this->content = $content; 
        return $this; 
    }

    public function getSentAt(): \DateTimeInterface 
    { 
        return $this->sentAt; 
    }

    public function setSentAt(\DateTimeInterface $sentAt): static 
    { 
        $this->sentAt = $sentAt; 
        return $this; 
    }

    public function getUser(): User 
    { 
        return $this->user; 
    }

    public function setUser(User $user): static 
    { 
        $this->user = $user; 
        return $this; 
    }

    public function getRecipe(): Recipe 
    { 
        return $this->recipe; 
    }

    public function setRecipe(Recipe $recipe): static 
    { 
        $this->recipe = $recipe; 
        return $this; 
    }
}
