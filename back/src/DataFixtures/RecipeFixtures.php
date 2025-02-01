<?php
namespace App\DataFixtures;

use App\Entity\Recipe;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RecipeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $users = $manager->getRepository(User::class)->findAll();

        if (empty($users)) {
            throw new \Exception("Les utilisateurs sont absents. Vérifie que UserFixtures est bien chargée en premier.");
        }

        $recipes = [
            ['Salade César', 'Entrée', 'salade_cesar.jpg', ['Griller le poulet', 'Mélanger avec la laitue', 'Ajouter la sauce'], 0],
            ['Bœuf Bourguignon', 'Plat principal', 'boeuf_bourguignon.jpg', ['Faire revenir la viande', 'Ajouter les légumes', 'Laisser mijoter'], 1],
            ['Tarte aux Fraises', 'Dessert', 'tarte_fraises.jpg', ['Cuire la pâte', 'Ajouter la crème', 'Disposer les fraises'], 2],
            ['Soupe de potiron', 'Entrée', 'soupe_potiron.jpg', ['Cuire le potiron', 'Mixer avec le bouillon', 'Ajouter la crème'], 1],
            ['Ratatouille', 'Plat principal', 'ratatouille.jpg', ['Couper les légumes', 'Faire revenir à feu doux'], 0],
            ['Poulet au curry', 'Plat principal', 'poulet_curry.jpg', ['Faire revenir le poulet', 'Ajouter le curry et la crème'], 2],
            ['Lasagnes', 'Plat principal', 'lasagnes.jpg', ['Monter les couches', 'Cuire au four'], 1],
            ['Crêpes sucrées', 'Dessert', 'crepes_sucrees.jpg', ['Mélanger les ingrédients', 'Cuire à la poêle'], 0],
            ['Mousse au chocolat', 'Dessert', 'mousse_chocolat.jpg', ['Faire fondre le chocolat', 'Incorporer les blancs montés en neige'], 1],
            ['Smoothie banane-fraise', 'Dessert', 'smoothie_banane_fraise.jpg', ['Mixer les ingrédients'], 2],
        ];

        foreach ($recipes as [$name, $category, $image, $cookingSteps, $userIndex]) {
            if (!isset($users[$userIndex])) {
                continue;
            }

            $recipe = new Recipe();
            $recipe->setName($name);
            $recipe->setCategory($category);
            $recipe->setCookingSteps($cookingSteps);
            $recipe->setCreatedBy($users[$userIndex]);

            // Path to the image, imgs is inside the DataFixtures folder
            $imagePath = __DIR__ . '/imgs/' . $image;  // Path adjusted for imgs inside DataFixtures

            // Read the image and convert it to base64
            $imageContent = file_get_contents($imagePath);
            $base64Image = base64_encode($imageContent);  // Convert to base64

            // Add the base64 prefix for image type
            $base64ImageWithPrefix = 'data:image/jpeg;base64,' . $base64Image;

            // Store the image in base64 format with prefix in the database
            $recipe->setImage($base64ImageWithPrefix);

            // Add random views between 0 and 500
            $recipe->setViews(rand(0, 500));

            $manager->persist($recipe);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}


