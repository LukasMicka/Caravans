<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Caravan;

class CaravanController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index()
    {
        return $this->render('caravan/index.html.twig', [
            'controller_name' => 'CaravanController',
        ]);
    }

    /**
     * @Route("/karavany", name="caravans")
     */ 
    public function list()
    {
        $em = $this->getDoctrine()->getManager();
        $repoCaravans = $em->getRepository(Caravan::class);
        $caravans = $repoCaravans->findAll();

        $start = new \DateTime( '01.02.2020' );
        $end = new \DateTime( '20.02.2020' );
        $end = $end->modify( '+1 day' );
        $interval = new \DateInterval('P1D');
        $bookedPeriod = new \DatePeriod($start, $interval ,$end);

        $bookedDates = [];
        foreach($bookedPeriod as $date){
            $bookedDates[] = $date->format("d.m.Y");
        }

        return $this->render('caravan/list.html.twig', [
            'caravans' => $caravans,
            'datesDisabled' => $bookedDates,
        ]);
    }
}
