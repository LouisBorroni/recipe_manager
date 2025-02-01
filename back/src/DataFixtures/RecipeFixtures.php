<?php

namespace App\DataFixtures;

use App\Entity\Recipe;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RecipeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $categories = $manager->getRepository(Category::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();

        if (empty($categories) || empty($users)) {
            throw new \Exception("Les catégories ou les utilisateurs sont absents. Vérifie que CategoryFixtures et UserFixtures sont bien chargées en premier.");
        }

        $recipes = [
              // Liste de recettes pré-définies avec leurs attributs LL
            ['Salade César', 'Une salade classique avec du poulet grillé.', 'Laitue, Poulet, Croutons, Parmesan, Sauce César', '1. Griller le poulet. 2. Mélanger avec la laitue. 3. Ajouter la sauce.', 'Facile', 15, 0, 0],
            ['Bœuf Bourguignon', 'Un plat mijoté de la cuisine française.', 'Bœuf, Vin rouge, Carottes, Oignons, Champignons', '1. Faire revenir la viande. 2. Ajouter les légumes. 3. Laisser mijoter.', 'Difficile', 180, 1, 1],
            ['Tarte aux Fraises', 'Une tarte sucrée aux fraises fraîches.', 'Pâte sablée, Crème pâtissière, Fraises, Sucre glace', '1. Cuire la pâte. 2. Ajouter la crème. 3. Disposer les fraises.', 'Moyenne', 45, 2, 2],
            ['Soupe de potiron', 'Une soupe douce et réconfortante.', 'Potiron, Oignon, Bouillon, Crème', '1. Cuire le potiron. 2. Mixer avec le bouillon. 3. Ajouter la crème.', 'Facile', 30, 0, 1],
            ['Ratatouille', 'Un mélange de légumes méditerranéens.', 'Aubergines, Courgettes, Poivrons, Tomates', '1. Couper les légumes. 2. Faire revenir à feu doux.', 'Facile', 45, 1, 0],
            ['Poulet au curry', 'Un plat épicé et savoureux.', 'Poulet, Curry, Crème, Riz', '1. Faire revenir le poulet. 2. Ajouter le curry et la crème.', 'Moyenne', 40, 1, 2],
            ['Lasagnes', 'Un classique de la cuisine italienne.', 'Pâtes, Sauce tomate, Viande hachée, Fromage', '1. Monter les couches. 2. Cuire au four.', 'Difficile', 90, 1, 1],
            ['Crêpes sucrées', 'De délicieuses crêpes pour le dessert.', 'Farine, Oeufs, Lait, Sucre', '1. Mélanger les ingrédients. 2. Cuire à la poêle.', 'Facile', 20, 2, 0],
            ['Mousse au chocolat', 'Un dessert aérien et gourmand.', 'Chocolat, Oeufs, Sucre', '1. Faire fondre le chocolat. 2. Incorporer les blancs montés en neige.', 'Moyenne', 25, 2, 1],
            ['Smoothie banane-fraise', 'Un smoothie fruité et rafraîchissant.', 'Banane, Fraises, Yaourt', '1. Mixer les ingrédients.', 'Facile', 5, 3, 2],
            ['Cocktail Mojito', 'Un cocktail cubain rafraîchissant.', 'Rhum, Menthe, Citron vert, Sucre', '1. Mélanger la menthe avec le sucre et le citron. 2. Ajouter le rhum et la glace.', 'Facile', 10, 3, 0],
            ['Pizza Margherita', 'Une pizza simple mais délicieuse.', 'Pâte à pizza, Sauce tomate, Mozzarella, Basilic', '1. Garnir la pâte. 2. Cuire au four.', 'Moyenne', 30, 1, 1],
            ['Burger maison', 'Un burger savoureux à préparer soi-même.', 'Pain burger, Viande hachée, Salade, Tomate, Fromage', '1. Cuire la viande. 2. Monter le burger.', 'Moyenne', 25, 1, 2],
            ['Risotto aux champignons', 'Un risotto crémeux et parfumé.', 'Riz Arborio, Champignons, Bouillon, Parmesan', '1. Cuire le riz avec le bouillon. 2. Ajouter les champignons.', 'Difficile', 50, 1, 0],
            ['Gâteau au chocolat', 'Un gâteau moelleux au chocolat.', 'Chocolat, Beurre, Oeufs, Farine', '1. Mélanger les ingrédients. 2. Cuire au four.', 'Moyenne', 40, 2, 1],
            ['Brownies', 'De délicieux brownies fondants.', 'Chocolat, Beurre, Oeufs, Sucre, Noix', '1. Mélanger les ingrédients. 2. Cuire au four.', 'Facile', 35, 2, 2],
            ['Tiramisu', 'Un dessert italien au café et mascarpone.', 'Mascarpone, Café, Biscuits, Cacao', '1. Monter les couches. 2. Laisser reposer au frais.', 'Moyenne', 60, 2, 0]
        ];

        foreach ($recipes as $key => [$title, $description, $ingredients, $instructions, $difficulty, $preparationTime, $categoryIndex, $userIndex]) {
            if (!isset($categories[$categoryIndex]) || !isset($users[$userIndex])) {
                continue; // Évite une erreur si l'index n'existe pas
            }

            $recipe = new Recipe();
            $recipe->setTitle($title);
            $recipe->setDescription($description);
            $recipe->setIngredients($ingredients);
            $recipe->setInstructions($instructions);
            $recipe->setDifficulty($difficulty);
            $recipe->setPreparationTime($preparationTime);

            $recipe->setCategory($categories[$categoryIndex]);
            $recipe->setUser($users[$userIndex]);

            $manager->persist($recipe);
        }

        $manager->flush();
    }

    public function getDependencies(): array 
    {
        // Définit les dépendances pour garantir que les catégories et utilisateurs sont disponibles LL
        return [
            CategoryFixtures::class,
            UserFixtures::class,
        ];
    }
}
