<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/profile/user', name: 'app_user')]
    public function user(): Response
    {
        $user = $this->getUser();

        return $this->render('user/monCompte.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/admin/users', name: 'app_users')]
    public function allUsers(ManagerRegistry $doctrine)
    {

        $users = $doctrine->getRepository(User::class)->findAll();

        return $this->render('user/users.html.twig', [
            'users' => $users
        ]); 

    }
}
