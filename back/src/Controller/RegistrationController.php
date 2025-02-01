<?php
// src/Controller/RegistrationController.php
namespace App\Controller;

use App\DTO\RegisterDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/api/register', name: 'app_register', methods: ['POST'])]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        ValidatorInterface $validator
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $registerDTO = new RegisterDTO();
        $registerDTO->email = $data['email'];
        $registerDTO->pseudo = $data['pseudo'];
        $registerDTO->password = $data['password'];

        $errors = $validator->validate($registerDTO);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return new JsonResponse(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }

        if (!filter_var($registerDTO->email, FILTER_VALIDATE_EMAIL)) {
            return new JsonResponse(['error' => 'The email is not valid.'], JsonResponse::HTTP_BAD_REQUEST);
        }

        if ($userRepository->findOneBy(['email' => $registerDTO->email])) {
            return new JsonResponse(['error' => 'Email already used.'], JsonResponse::HTTP_CONFLICT);
        }

        $user = new User();
        $user->setEmail($registerDTO->email);
        $user->setPseudo($registerDTO->pseudo); 
        $hashedPassword = $passwordHasher->hashPassword($user, $registerDTO->password);
        $user->setPassword($hashedPassword);

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['message' => 'User successfully registered'], JsonResponse::HTTP_CREATED);
    }
}
