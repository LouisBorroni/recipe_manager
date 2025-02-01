<?php 
namespace App\Tests\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{
    private $entityManager;

    public function testLoginWithValidCredentials()
    {
        $client = static::createClient();
        $this->entityManager = $client->getContainer()->get('doctrine')->getManager();

        $user = new User();
        $user->setEmail('testuser@example.com');
        $user->setPassword(password_hash('Password123!', PASSWORD_BCRYPT));
        $user->setPseudo('testuser');
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $client->request(
            'POST',
            '/api/login_check',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => 'testuser@example.com',
                'password' => 'Password123!',
            ])
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('token', $response);
        $this->assertNotEmpty($response['token']);
    }

    public function testLoginWithInvalidCredentials()
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/login_check',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => 'invaliduser@example.com',
                'password' => 'WrongPassword',
            ])
        );

        // Vérifier si la réponse est une erreur 401
        $this->assertEquals(401, $client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['code' => 401, 'message' => 'Invalid credentials.']),
            $client->getResponse()->getContent()
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        if ($this->entityManager) {
            $this->entityManager->createQuery('DELETE FROM App\Entity\User u WHERE u.email LIKE :email')
                ->setParameter('email', '%@example.com%')
                ->execute();
            $this->entityManager->close();
            $this->entityManager = null; 
        }
    }
}
