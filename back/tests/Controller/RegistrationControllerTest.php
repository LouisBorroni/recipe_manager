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
                'password' => 'Password123!', 
                'pseudo' => 'test'
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

        $user = new User();
        $user->setEmail('existing@example.com');
        $user->setPassword('Password123!');
        $user->setPseudo('existing');
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
                'password' => 'Password123!', 
                'pseudo' => 'existing'
            ])
        );

        $this->assertEquals(409, $client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['error' => 'Email already used.']),
            $client->getResponse()->getContent()
        );
    }

    public function testRegisterWithInvalidPassword()
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
                'email' => 'test2@example.com',
                'password' => 'short',
                'pseudo' => 'test'
            ])
        );

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['error' => 'Password must be at least 10 characters long.']),
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
