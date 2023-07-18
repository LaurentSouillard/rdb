<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
        
    }

    #[Route(path: '/confirmation-de-compte_{token}', name: 'confirmation_compte')]
    public function confirmationCompte($token, EntityManagerInterface $manager, ManagerRegistry $doctrine)
    {
        //on récupere l'utilisateur avec le token passé dans l'url
        $user = $doctrine->getRepository(User::class)->findOneBy(["token" => $token]);

        // on verifie si un user à été trouvé
        if(!$user)
        {
            $this->addFlash("erreur", "Aucun Utilisateur a activer ! Veuillez vous connectez si vous avez déja activé votre compte ou vous inscrire le cas échéant");

            return $this->redirectToRoute('app_login');
        }

        $user->setToken(null)
            ->setIsVerified(true);

        $manager->persist($user);
        $manager->flush();

        $this->addFlash("success", "Félicitations, votre compte est maintenant activé, vous pouvez vous connecter ");

        return $this->redirectToRoute('app_login');
    } 

}
