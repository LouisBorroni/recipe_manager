<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = [
            ["Entrées", "Des plats légers pour commencer un repas."],
            ["Plats", "Recettes principales pour le déjeuner ou le dîner."],
            ["Desserts", "Gourmandises sucrées pour finir en beauté."],
            ["Boissons", "Recettes de cocktails, jus, et autres boissons."]
        ];

        foreach ($categories as $key => [$name, $description]) {
            $category = new Category();
            $category->setName($name);
            $category->setDescription($description);

            $manager->persist($category);
            $this->addReference("category_$key", $category);
        }

        $manager->flush();
    }
}
