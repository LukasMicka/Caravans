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

        return $this->render('caravan/list.html.twig', [
            'caravans' => $caravans,
        ]);
    }
}
