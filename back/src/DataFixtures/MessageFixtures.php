<?php

namespace App\DataFixtures;

use App\Entity\Message;
use App\Entity\User;
use App\Entity\Recipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MessageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $users = $manager->getRepository(User::class)->findAll();
        $recipes = $manager->getRepository(Recipe::class)->findAll();

        if (empty($users) || empty($recipes)) {
            throw new \Exception("Les utilisateurs ou les recettes sont absents. Vérifie que UserFixtures et RecipeFixtures sont bien chargées en premier.");
        }

        $messages = [
            ['J’ai testé cette recette hier, c’était délicieux !', 0, 0],
            ['Une excellente recette, facile à suivre.', 1, 1],
            ['La meilleure tarte aux fraises que j’ai jamais faite !', 2, 2]
        ];

        foreach ($messages as [$content, $userIndex, $recipeIndex]) {
            if (!isset($users[$userIndex]) || !isset($recipes[$recipeIndex])) {
                continue; // Évite une erreur si l'index n'existe pas
            }

            $message = new Message();
            $message->setContent($content);
            $message->setUser($users[$userIndex]);
            $message->setRecipe($recipes[$recipeIndex]);

            $manager->persist($message);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            RecipeFixtures::class,
        ];
    }
}
