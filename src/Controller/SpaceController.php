<?php

namespace App\Controller;

use App\Entity\Space;

use App\Form\SpaceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SpaceController extends AbstractController
{

    #[Route('/space', name: 'app_space')]
    public function index(): Response
    {
        return $this->render('space/space.html.twig', [
            'controller_name' => 'SpaceController',
        ]);
    }

    #[Route('/admin/space_ajout', name: 'app_space_ajout')]
    public function ajout(Request $request, SluggerInterface $slugger, EntityManagerInterface $manager): Response
    {
        // on verifie si l'utilisateur est connecté
        if( !$this->isGranted('IS_AUTHENTICATED_FULLY') )
        {
            $this->addFlash("erreur", "veuillez vous connecter avant de consulter cette page ! ! !");

            return $this->redirectToRoute('app_login');
        }

        // l'utilateur est connecté, on verifie maintenant si son role est ADMIN
        if( !$this->isGranted("ROLE_ADMIN"))
        {
            $this->addFlash("erreur", "vous n'êtes pas autorisé à accéder à cette page, veullez contacter l'administrateur du site !");

            return $this->redirectToRoute("app_home");
        }
        
        $space = new Space();

        
        $form = $this->createForm(SpaceType::class, $space);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            // on crée le slug du nom de la categorie 
            $slug = $slugger->slug($space->getNom());

            $space->setSlug($slug);

            $manager->persist($space);
            $manager->flush();

            return $this->redirectToRoute('app_space');
           
        }

        return $this->render('space/formulaire.html.twig', [
            'formSpace' => $form->createView(),
        ]);
    }
}
