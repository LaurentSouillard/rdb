<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationController extends AbstractController
{
    #[Route('/profile/reservation', name: 'app_reservation')]
    public function reservation(EntityManagerInterface $manager, Request $request): Response
    {
        $reservation = new Reservation();

        $form = $this->createForm(ReservationType::class, $reservation);

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() )
        {

            // on récupere l'utilisateur connecté
            $user = $this->getUser();
            // on l'affecte à la reservation en cours
            $reservation->setUser($user);

            $manager->persist($reservation);

            $manager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('reservation/reservation.html.twig', [
            'formReservation' => $form->createView(),
        ]);
    }

    #[Route('/admin/reservations', name: 'app_reservations')]
    public function allReservations(ManagerRegistry $doctrine)
    {

        $reservations = $doctrine->getRepository(Reservation::class)->findAll();

        return $this->render('reservation/reservations.html.twig', [
            'reservations' => $reservations
        ]); 

    }

    #[Route('/admin/reservation_{id<\d+>}', name: 'app_uneReservation')]
    public function uneReservation($id, Request $request, EntityManagerInterface $manager, ManagerRegistry $doctrine)
    {

        $reservation = $doctrine->getRepository(Reservation::class)->find($id);
        

        return $this->render('reservation/uneReservation.html.twig', [
            'reservation' => $reservation
        ]); 

    }

    #[Route('/admin/reservation_delete_{id<\d+>}', name: 'app_delete_uneReservation')]
    public function delete($id, EntityManagerInterface $manager, ManagerRegistry $doctrine)
    {

        $reservation = $doctrine->getRepository(Reservation::class)->find($id);
        
        $manager->remove($reservation);

        $manager->flush();

        return $this->render('reservation/reservations.html.twig'); 

    }

    #[Route('/admin/reservation_update_{id<\d+>}', name: 'app_update_uneReservation')]
    public function update($id, EntityManagerInterface $manager, ManagerRegistry $doctrine, Request $request)
    {

        $reservation = $doctrine->getRepository(Reservation::class)->find($id);

        $form = $this->createForm(ReservationType::class, $reservation);

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ){
        
            $manager->persist($reservation);

            $manager->flush();

            return $this->redirectToRoute('app_reservations');

        }

        return $this->render('reservation/reservation.html.twig', [
            'formReservation' => $form->createView()
        ]); 

    }
}
