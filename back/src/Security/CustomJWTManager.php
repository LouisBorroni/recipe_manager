<?php
namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;
use Symfony\Component\Security\Core\Security;
use App\Entity\User; 

class CustomJWTManager
{
    private $jwtManager;
    private $security;

    public function __construct(JWTManager $jwtManager, Security $security)
    {
        $this->jwtManager = $jwtManager;
        $this->security = $security;
    }

    public function createToken(): string
    {
        // Récupérer l'utilisateur connecté
        $user = $this->security->getUser();

        // Vérifie que l'utilisateur est connecté
        if (!$user instanceof User) {
            throw new \LogicException('L\'utilisateur doit être connecté');
        }

        // Ajouter l'ID de l'utilisateur au payload du token
        $payload = [
            'username' => $user->getUsername(),
            'id' => $user->getId(),  // Ajoute l'ID de l'utilisateur
            // Tu peux ajouter d'autres informations si nécessaire
        ];

        // Créer le token JWT avec ce payload
        return $this->jwtManager->create($user);
    }
}
