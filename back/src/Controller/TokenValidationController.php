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
        $authHeader = $request->headers->get('Authorization');
        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return new JsonResponse(['isValid' => false, 'message' => 'No token provided'], 401);
        }

        $token = $matches[1];

        try {
            $decodedToken = $this->jwtEncoder->decode($token);

            if ($decodedToken) {
                return new JsonResponse([
                    'isValid' => true,
                    'user' => [
                        'username' => $decodedToken['username'],
                        'roles' => $decodedToken['roles'],
                    ]
                ]);
            } else {
                return new JsonResponse(['isValid' => false, 'message' => 'Invalid token'], 401);
            }
        } catch (AuthenticationException $e) {
            return new JsonResponse(['isValid' => false, 'message' => 'Invalid or expired token'], 401);
        }
    }
}

