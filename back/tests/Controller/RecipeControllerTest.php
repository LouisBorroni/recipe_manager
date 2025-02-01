namespace App\Tests\Controller;

use App\Controller\RecipeController;
use App\Entity\Recipe;
use App\Entity\User;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class RecipeControllerTest extends WebTestCase
{
    private $entityManager;
    private $tokenStorage;
    private $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $client = static::createClient();
        $this->entityManager = $client->getContainer()->get('doctrine')->getManager();
        $this->tokenStorage = $client->getContainer()->get(TokenStorageInterface::class);
        $this->controller = new RecipeController(
            $this->entityManager,
            $this->tokenStorage,
            $client->getContainer()->get(RecipeRepository::class)
        );
    }

    public function testCreateRecipe(): void
    {
        $user = new User();
        $user->setPseudo('testUser'); 
        $user->setEmail('testuser@example.com'); 
        $user->setPassword('TestPassword123!'); 

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $token = $this->createMock(TokenInterface::class);
        $token->method('getUser')->willReturn($user); 

        $this->tokenStorage->method('getToken')->willReturn($token);

        $data = [
            'name' => 'Test Recipe',
            'category' => 'Dessert',
            'image' => 'data:image/jpeg;base64,validbase64encodedimage',
            'cookingSteps' => ['Step 1', 'Step 2']
        ];

        $request = $this->createMock(Request::class);
        $request->method('getContent')->willReturn(json_encode($data));

        $recipe = new Recipe();
        $recipe->setName($data['name']);
        $recipe->setCategory($data['category']);
        $recipe->setImage($data['image']);
        $recipe->setCookingSteps($data['cookingSteps']);
        $recipe->setCreatedBy($user);

      
        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($this->equalTo($recipe));
        $this->entityManager->expects($this->once())
            ->method('flush');

      
        $response = $this->controller->createRecipe($request);

        $this->assertEquals(JsonResponse::HTTP_CREATED, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'message' => 'Recipe created successfully',
                'recipe' => [
                    'name' => $data['name'],
                    'category' => $data['category'],
                    'image' => $data['image'],
                    'cookingSteps' => $data['cookingSteps']
                ]
            ]),
            $response->getContent()
        );
    }

    // TODO faire les autres tests pour les différentes méthodes du controller.

    protected function tearDown(): void
    {
        parent::tearDown();
        if ($this->entityManager) {
            $this->entityManager->createQuery('DELETE FROM App\Entity\Recipe r WHERE r.name LIKE :name')
                ->setParameter('name', '%Test Recipe%')
                ->execute();
            $this->entityManager->close();
            $this->entityManager = null;
        }
    }
}
