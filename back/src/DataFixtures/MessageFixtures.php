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
        // Récupération de tous les utilisateurs et recettes depuis la base de données. LL
        $users = $manager->getRepository(User::class)->findAll();
        $recipes = $manager->getRepository(Recipe::class)->findAll();

        // Vérifie que des utilisateurs et des recettes existent avant d'ajouter des messages. LL
        if (empty($users) || empty($recipes)) {
            throw new \Exception("Les utilisateurs ou les recettes sont absents. Vérifie que UserFixtures et RecipeFixtures sont bien chargées en premier.");
        }

        // Liste des messages à insérer, avec l'index de l'utilisateur et de la recette associée. LL
        $messages = [
            ['J’ai testé cette recette hier, c’était délicieux !', 0, 0],
            ['Une excellente recette, facile à suivre.', 1, 1],
            ['La meilleure tarte aux fraises que j’ai jamais faite !', 2, 2]
        ];

        foreach ($messages as [$content, $userIndex, $recipeIndex]) {
            // Vérifie que l'utilisateur et la recette associés existent avant d'ajouter le message. LL
            if (!isset($users[$userIndex]) || !isset($recipes[$recipeIndex])) {
                continue;
            }

            // Création d'un nouveau message et assignation des valeurs. LL
            $message = new Message();
            $message->setContent($content);
            $message->setUser($users[$userIndex]);
            $message->setRecipe($recipes[$recipeIndex]);

            // Préparation de l'enregistrement en base de données. LL
            $manager->persist($message);
        }

        // Exécute l'enregistrement des messages en base de données. LL
        $manager->flush();
    }

    public function getDependencies(): array
    {
        // Dépendances nécessaires pour garantir que les utilisateurs et recettes existent avant d'insérer les messages. LL
        return [
            UserFixtures::class,
            RecipeFixtures::class,
        ];
    }
}
