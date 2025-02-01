<?php
namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserController extends AbstractController
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    #[Route('/api/user_infos', name: 'get_user_info', methods: ['GET'])]
    public function getUserInfo(): JsonResponse
    {
        $token = $this->tokenStorage->getToken();  
        if (!$token) {
            return new JsonResponse(['error' => 'No authentication token provided'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $user = $this->getUser();  

        if (!$user) {
            return new JsonResponse(['error' => 'User not authenticated'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $userData = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
            'pseudo' => $user->getPseudo(),
            'userRecipes' => []
        ];

        foreach ($user->getRecipes() as $recipe) {
            $userData['userRecipes'][] = [
                'id' => $recipe->getId(),
                'name' => $recipe->getName(),
                'category' => $recipe->getCategory(),
                'image' => $recipe->getImage(),
                'cookingSteps' => $recipe->getCookingSteps(),
                'views' => $recipe->getViews(),
                'createdBy' => $recipe->getCreatedBy()->getPseudo()
            ];
        }

        return new JsonResponse($userData, JsonResponse::HTTP_OK);
    }
}

