<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MeController extends AbstractController
{
   
    public function __construct(private Security $security , private UserRepository $userRepository ) {}

    public function __invoke() 
    {   
        $user = $this->security->getUser();
        return $user;
    }
}
