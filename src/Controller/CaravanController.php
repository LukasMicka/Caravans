<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Caravan;
use App\Entity\Reservation;

class CaravanController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index(): Response
    {
        return $this->render('caravan/index.html.twig', [
            'controller_name' => 'CaravanController',
        ]);
    }

    /**
     * @Route("/karavany", name="caravans")
     */ 
    public function list(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $repoCaravans = $em->getRepository(Caravan::class);
        $caravans = $repoCaravans->findAll();
        $repoReservations = $em->getRepository(Reservation::class);
        $reservations = $repoReservations->findAllReservations();
        
        $existingReservations = [];
        $interval = new \DateInterval('P1D');
        foreach ($reservations as $reservation) {
            $from = $reservation->getReservationFrom();
            $to = $reservation->getReservationTo()->modify('+1 day');
            $existingReservations[$reservation->getCaravan()->getId()][] = new \DatePeriod($from, $interval, $to);
        }
        
        $bookedDates = [];
        foreach ($existingReservations as $caravanId => $reservations) {
            foreach ($reservations as $datePeriod) {
                foreach($datePeriod as $date) {
                    $bookedDates[$caravanId][] = $date->format("d.m.Y");
                }
            }
        }
        
        return $this->render('caravan/list.html.twig', [
            'caravans' => $caravans,
            'datesDisabled' => $bookedDates,
        ]);
    }
}
