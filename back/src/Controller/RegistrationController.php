<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/api/register', name: 'app_register', methods: ['POST'])]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, UserRepository $userRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Vérifier si l'email existe déjà
        if ($userRepository->findOneBy(['email' => $data['email']])) {
            return new JsonResponse(['error' => 'Email already used.'], JsonResponse::HTTP_CONFLICT);
        }

        // Vérifier si le pseudo existe déjà
        if (isset($data['pseudo']) && $userRepository->findOneBy(['pseudo' => $data['pseudo']])) {
            return new JsonResponse(['error' => 'Pseudo already used.'], JsonResponse::HTTP_CONFLICT);
        }

        // Vérifier si le pseudo est bien défini
        if (!isset($data['pseudo']) || empty($data['pseudo'])) {
            return new JsonResponse(['error' => 'Pseudo is required.'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Créer un nouvel utilisateur
        $user = new User();
        $user->setEmail($data['email']);
        $user->setPseudo($data['pseudo']);  // Assigner le pseudo
        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        // Sauvegarder l'utilisateur dans la base de données
        $entityManager->persist($user);
        $entityManager->flush();

        // Réponse avec un message de succès
        return new JsonResponse(['message' => 'User successfully registered'], JsonResponse::HTTP_CREATED);
    }
}
