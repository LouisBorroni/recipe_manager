<?php

namespace App\Tests\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    private $entityManager;

    public function testRegister()
    {
        $client = static::createClient();
        $this->entityManager = $client->getContainer()->get('doctrine')->getManager();

        $client->request(
            'POST',
            '/api/register',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => 'test@example.com',
                'password' => 'password123'
            ])
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'User successfully registered']),
            $client->getResponse()->getContent()
        );
    }

    public function testRegisterWithExistingEmail()
    {
        $client = static::createClient();
        $this->entityManager = $client->getContainer()->get('doctrine')->getManager();

        // Créer un utilisateur existant pour le test
        $user = new User();
        $user->setEmail('existing@example.com');
        $user->setPassword('hashedpassword'); // Assurez-vous d'utiliser un hash de mot de passe valide
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $client->request(
            'POST',
            '/api/register',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => 'existing@example.com',
                'password' => 'password123'
            ])
        );

        $this->assertEquals(409, $client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['error' => 'Email already used.']),
            $client->getResponse()->getContent()
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        // Supprimer les utilisateurs de test pour éviter les conflits dans d'autres tests
        if ($this->entityManager) {
            $this->entityManager->createQuery('DELETE FROM App\Entity\User u WHERE u.email LIKE :email')
                ->setParameter('email', '%@example.com%')
                ->execute();
            $this->entityManager->close();
            $this->entityManager = null; // Éviter les fuites de mémoire
        }
    }
}
