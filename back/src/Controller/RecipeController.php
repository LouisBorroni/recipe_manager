<?php 
namespace App\Controller;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RecipeController extends AbstractController
{
    private $entityManager;
    private $tokenStorage;
    private $recipeRepository;

    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage, RecipeRepository $recipeRepository)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->recipeRepository = $recipeRepository;
    }

    #[Route('/api/recipes', name: 'create_recipe', methods: ['POST'])]
    public function createRecipe(Request $request): JsonResponse
    {
        $user = $this->getUser();

        if (!$user) {
            return new JsonResponse(['error' => 'User not authenticated'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $data = json_decode($request->getContent(), true);

        if (!isset($data['name'], $data['category'], $data['image'], $data['cookingSteps'])) {
            return new JsonResponse(['error' => 'Missing required fields'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $recipe = new Recipe();
        $recipe->setName($data['name']);
        $recipe->setCategory($data['category']);
        $recipe->setImage($data['image']); 
        $recipe->setcookingSteps($data['cookingSteps']);

        $recipe->setCreatedBy($user);

        $this->entityManager->persist($recipe);
        $this->entityManager->flush();

        return new JsonResponse([
            'message' => 'Recipe created successfully',
            'recipe' => [
                'id' => $recipe->getId(),
                'name' => $recipe->getName(),
                'category' => $recipe->getCategory(),
                'image' => $recipe->getImage(),
                'cookingSteps' => $recipe->getcookingSteps()
            ]
        ], JsonResponse::HTTP_CREATED);
    }

    #[Route('/api/recipes/{id}', name: 'update_recipe', methods: ['PUT'])]
    public function updateRecipe(int $id, Request $request): JsonResponse
    {
        $user = $this->getUser();  

        if (!$user) {
            return new JsonResponse(['error' => 'User not authenticated'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $recipe = $this->entityManager->getRepository(Recipe::class)->find($id);

        if (!$recipe) {
            return new JsonResponse(['error' => 'Recipe not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        if ($recipe->getCreatedBy() !== $user) {
            return new JsonResponse(['error' => 'You are not authorized to update this recipe'], JsonResponse::HTTP_FORBIDDEN);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['name'])) {
            $recipe->setName($data['name']);
        }
        if (isset($data['category'])) {
            $recipe->setCategory($data['category']);
        }
        if (isset($data['image'])) {
            $recipe->setImage($data['image']);
        }
        if (isset($data['cookingSteps'])) {
            $recipe->setCookingSteps($data['cookingSteps']);
        }

        $this->entityManager->flush();

        return new JsonResponse([
            'message' => 'Recipe updated successfully',
            'recipe' => [
                'id' => $recipe->getId(),
                'name' => $recipe->getName(),
                'category' => $recipe->getCategory(),
                'image' => $recipe->getImage(),
                'cookingSteps' => $recipe->getCookingSteps()
            ]
        ], JsonResponse::HTTP_OK);
    }

    #[Route('/api/recipes/{id}', name: 'delete_recipe', methods: ['DELETE'])]
    public function deleteRecipe(int $id): JsonResponse
    {
        
        $user = $this->getUser(); 

        if (!$user) {
            return new JsonResponse(['error' => 'User not authenticated'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $recipe = $this->entityManager->getRepository(Recipe::class)->find($id);

        if (!$recipe) {
            return new JsonResponse(['error' => 'Recipe not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        if ($recipe->getCreatedBy() !== $user) {
            return new JsonResponse(['error' => 'You are not authorized to delete this recipe'], JsonResponse::HTTP_FORBIDDEN);
        }

        $this->entityManager->remove($recipe);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Recipe deleted successfully'], JsonResponse::HTTP_OK);
    }

    #[Route('/api/recipe/add-view/{id}', name: 'add_recipe_view', methods: ['POST'])]
    public function addView(int $id): JsonResponse
    {
        $recipe = $this->recipeRepository->find($id);

        if (!$recipe) {
            return $this->json(['error' => 'Recipe not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $recipe->setViews($recipe->getViews() + 1);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'View incremented successfully',
            'newViews' => $recipe->getViews()
        ]);
    }

    #[Route('/api/trend_recipes', name: 'top_recipes', methods: ['GET'])]
    public function getTopRecipes(): JsonResponse
    {
        $recipes = $this->recipeRepository->createQueryBuilder('r')
            ->orderBy('r.views', 'DESC') 
            ->setMaxResults(30)          
            ->getQuery()
            ->getResult();

        $recipeData = array_map(function (Recipe $recipe) {
            return [
                'id' => $recipe->getId(),
                'name' => $recipe->getName(),
                'category' => $recipe->getCategory(),
                'image' => $recipe->getImage(),
                'cookingSteps' => $recipe->getCookingSteps(),
                'views' => $recipe->getViews(),
                'createdBy' => $recipe->getCreatedBy()->getPseudo()
            ];
        }, $recipes);

        return new JsonResponse($recipeData, JsonResponse::HTTP_OK);
    }
}
