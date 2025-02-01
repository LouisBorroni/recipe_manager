<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Liste des catégories à insérer avec leur description. LL
        $categories = [
            ["Entrées", "Des plats légers pour commencer un repas."],
            ["Plats", "Recettes principales pour le déjeuner ou le dîner."],
            ["Desserts", "Gourmandises sucrées pour finir en beauté."],
            ["Boissons", "Recettes de cocktails, jus, et autres boissons."]
        ];

        foreach ($categories as $key => [$name, $description]) {
            // Création d'une nouvelle catégorie et assignation de ses valeurs. LL
            $category = new Category();
            $category->setName($name);
            $category->setDescription($description);

            // Préparation de l'enregistrement en base de données. LL
            $manager->persist($category);

            // Ajout d'une référence pour lier cette catégorie à d'autres fixtures si besoin. LL
            $this->addReference("category_$key", $category);
        }

        // Enregistre toutes les catégories en base de données. LL
        $manager->flush();
    }
}

//PHP Fatal error:  Uncaught Error: Class "Doctrine\Bundle\FixturesBundle\Fixture" not found in C:\Users\adm\recipe_manager\back\src\DataFixtures\CategoryFixtures.php:9
//Stack trace:
#0 {main}
  //thrown in C:\Users\adm\recipe_manager\back\src\DataFixtures\CategoryFixtures.php on line 9

  // Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle::class => ['all' => true],

