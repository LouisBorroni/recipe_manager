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
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);


        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return new JsonResponse(['error' => 'The email is not valid.'], JsonResponse::HTTP_BAD_REQUEST);
        }

        if ($userRepository->findOneBy(['email' => $data['email']])) {
            return new JsonResponse(['error' => 'Email already used.'], JsonResponse::HTTP_CONFLICT);
        }

        if (empty($data['pseudo']) || strlen($data['pseudo']) < 4) {
            return new JsonResponse(['error' => 'Pseudo must be at least 4 characters long.'], JsonResponse::HTTP_BAD_REQUEST);
        }

        if (empty($data['password']) || strlen($data['password']) < 10) {
            return new JsonResponse(['error' => 'Password must be at least 10 characters long.'], JsonResponse::HTTP_BAD_REQUEST);
        }

        if (!preg_match('/[A-Z]/', $data['password'])) {
            return new JsonResponse(['error' => 'Password must contain at least one uppercase letter.'], JsonResponse::HTTP_BAD_REQUEST);
        }

        if (!preg_match('/[0-9]/', $data['password'])) {
            return new JsonResponse(['error' => 'Password must contain at least one number.'], JsonResponse::HTTP_BAD_REQUEST);
        }

        if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $data['password'])) {
            return new JsonResponse(['error' => 'Password must contain at least one special character.'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $user = new User();
        $user->setEmail($data['email']);
        $user->setPseudo($data['pseudo']);
        
        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['message' => 'User successfully registered'], JsonResponse::HTTP_CREATED);
    }
}
