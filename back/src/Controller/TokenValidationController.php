<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class TokenValidationController extends AbstractController
{
    private JWTEncoderInterface $jwtEncoder;

    public function __construct(JWTEncoderInterface $jwtEncoder)
    {
        $this->jwtEncoder = $jwtEncoder;
    }

    public function validateToken(Request $request): JsonResponse
    {
        // Récupérer le token JWT à partir du header Authorization
        $authHeader = $request->headers->get('Authorization');
        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return new JsonResponse(['isValid' => false, 'message' => 'No token provided'], 401);
        }

        $token = $matches[1];

        try {
            // Utiliser JWTEncoderInterface pour décoder et valider le token
            $decodedToken = $this->jwtEncoder->decode($token);

            // Vérifier si le token est valide (s'il retourne des données)
            if ($decodedToken) {
                return new JsonResponse(['isValid' => true, 'decoded' => $decodedToken]);
            } else {
                return new JsonResponse(['isValid' => false, 'message' => 'Invalid token'], 401);
            }
        } catch (AuthenticationException $e) {
            return new JsonResponse(['isValid' => false, 'message' => 'Invalid or expired token'], 401);
        }
    }
}
