<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    // Injection du service de hashage de mot de passe. LL
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Liste des utilisateurs avec leur email et mot de passe en clair. LL
        $usersData = [
            ["admin@example.com", "password123"],
            ["user1@example.com", "password123"],
            ["user2@example.com", "password123"]
        ];

        foreach ($usersData as $key => [$email, $password]) {
            // Création d'un nouvel utilisateur et assignation de son email. LL
            $user = new User();
            $user->setEmail($email);

            // Hashage du mot de passe avant enregistrement. LL
            $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
            $user->setPassword($hashedPassword);

            // Préparation de l'utilisateur pour l'insertion en base de données. LL
            $manager->persist($user);

            // Ajout d'une référence pour pouvoir réutiliser ces utilisateurs dans d'autres fixtures. LL
            $this->addReference("user_$key", $user);
        }

        // Enregistrement des utilisateurs en base de données. LL
        $manager->flush();
    }
}
