<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;


class ApiLoginController extends AbstractController
{
    #[Route('/api/login', name: 'api_login' , methods: 'POST')]
    public function index(#[CurrentUser] ?User $user): JsonResponse
    {

        // $session = $this->getSubscribedServices(); 
        // $toto = $session->getMetadataBag()->getLifetime();
    
        // return $this->json([
        //     'message' => 'Welcome to your new controller!',
        //     'path' => 'src/Controller/ApiLoginController.php',
        // ]);

        $user = $this->getUser();
        // return $this->json($user);

        // $test = $this->getSubscribedServices();
        // return $this->json($test);
        // $token = $this->authenticationUtils();

        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials'
            ], Response::HTTP_UNAUTHORIZED );
        }

        return $this->json([
            //'user' => $user->getUserIdentifier(),
            // 'firstname' => $user->getFirstName(),
            // 'lastname' => $user->getLastName(),
            'roles' => $user->getRoles(),

            // 'token' => $token,
        ]);
    }
    #[Route('/api/logout', name: 'api_logout')]
    public function logout()
    {
        // throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
        return $this->json([
            'message' => 'disconnected'
        ]);
    }
}
