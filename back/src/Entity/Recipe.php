<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Category;
use App\Entity\User;

#[ORM\Entity]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    private string $title;

    #[ORM\Column(type: "text")]
    private string $description;

    #[ORM\Column(type: "text")]
    private string $ingredients;

    #[ORM\Column(type: "text")]
    private string $instructions;

    #[ORM\Column(type: "integer")]
    private int $preparationTime;

    #[ORM\Column(type: "string", length: 50)]
    private string $difficulty;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")] // 🔥 Suppression en cascade si la catégorie est supprimée
    private Category $category;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")] // 🔥 Suppression en cascade si l'utilisateur est supprimé
    private User $user;

    public function getId(): ?int 
    { 
        return $this->id; 
    }

    public function getTitle(): string 
    { 
        return $this->title; 
    }

    public function setTitle(string $title): static 
    { 
        $this->title = $title; 
        return $this; 
    }

    public function getDescription(): string 
    { 
        return $this->description; 
    }

    public function setDescription(string $description): static 
    { 
        $this->description = $description; 
        return $this; 
    }

    public function getIngredients(): string 
    { 
        return $this->ingredients; 
    }

    public function setIngredients(string $ingredients): static 
    { 
        $this->ingredients = $ingredients; 
        return $this; 
    }

    public function getInstructions(): string 
    { 
        return $this->instructions; 
    }

    public function setInstructions(string $instructions): static 
    { 
        $this->instructions = $instructions; 
        return $this; 
    }

    public function getPreparationTime(): int 
    { 
        return $this->preparationTime; 
    }

    public function setPreparationTime(int $time): static 
    { 
        $this->preparationTime = $time; 
        return $this; 
    }

    public function getDifficulty(): string 
    { 
        return $this->difficulty; 
    }

    public function setDifficulty(string $difficulty): static 
    { 
        $this->difficulty = $difficulty; 
        return $this; 
    }

    public function getImage(): ?string 
    { 
        return $this->image; 
    }

    public function setImage(?string $image): static 
    { 
        $this->image = $image; 
        return $this; 
    }

    public function getCategory(): Category 
    { 
        return $this->category; 
    }

    public function setCategory(Category $category): static 
    { 
        $this->category = $category; 
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
}
