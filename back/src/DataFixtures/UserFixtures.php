<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $usersData = [
            ["admin@example.com", "password123", ["ROLE_ADMIN"], "admin123"],
            ["user1@example.com", "password123", ["ROLE_USER"], "user1pseudo"],
            ["user2@example.com", "password123", ["ROLE_USER"], "user2pseudo"]
        ];

        foreach ($usersData as $key => [$email, $password, $roles, $pseudo]) {
            $user = new User();
            $user->setEmail($email);
            $user->setRoles($roles);
            $user->setPseudo($pseudo); 

            $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
            $user->setPassword($hashedPassword);

            $manager->persist($user);
            $this->addReference("user_$key", $user);
        }

        $manager->flush();
    }
}
